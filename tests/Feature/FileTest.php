<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Javaabu\Forms\Tests\TestCase;
use Javaabu\Forms\Tests\TestSupport\Models\Article;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class FileTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->setupFakeMediaDisk();
        $this->app['config']->set('defaults.max_upload_file_size', 1024 * 2);
        $this->app['config']->set('defaults.max_image_file_size', 1024 * 2);
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    protected function getArticleWithMedia(string $collection = 'featured_image'): Article
    {
        $article = new Article(['title' => 'Test article']);
        $article->save();

        $image_file = UploadedFile::fake()->image('some-cool-image.jpg', 1000, 500)->size(512);
        $article->addMedia($image_file)->toMediaCollection($collection);

        return $article;
    }

    /** @test */
    public function it_can_render_missing_file_inputs()
    {
        $article = $this->getArticleWithMedia();

        $this->setFrameworkMaterialAdmin26();

        Route::get('file-missing', function () use ($article) {
            return view('file-missing')
                ->with('article', $article);
        })->middleware('web');

        $this->visit('/file-missing')
            ->seeElement('div.form-group')
            ->within('div.form-group', function () {
                $this->seeElement('div.fileinput.fileinput-new')
                    ->within('div.fileinput', function () {
                        $this->seeElement('span.btn-file')
                            ->within('span.btn-file', function () {
                                $this->seeElement('input[name="og_image"][type="file"][accept="application/pdf,image/jpeg,image/png"]#og_image');
                            });

                        $this->seeElement('span.fileinput-filename')
                            ->within('span.fileinput-filename', function () {
                                $this->dontSeeElement('a');
                            });
                    });
            });
    }

    /** @test */
    public function it_can_render_file_input_with_value()
    {
        $this->setFrameworkMaterialAdmin26();

        $this->registerTestRoute('file-value');

        $this->visit('/file-value')
            ->seeElement('div.form-group')
            ->within('div.form-group', function () {
                $this->seeElement('div.fileinput.fileinput-exists')
                    ->within('div.fileinput', function () {
                        $this->seeElement('span.btn-file')
                            ->within('span.btn-file', function () {
                                $this->seeElement('input[name="featured_image"][type="file"][accept="application/pdf,image/jpeg,image/png"]#featured_image');
                            });

                        $this->seeElement('span.fileinput-filename')
                            ->within('span.fileinput-filename', function () {
                                $this->seeElement('a[href="https://example.com/uploads/Important-document.pdf?download=true"]')
                                     ->seeInElement('a', 'Important-document.pdf')
                                     ->dontSeeInElement('a', '?download=true')
                                    ->dontSeeInElement('a', 'https://example.com/uploads/');
                            });
                    });
            });
    }

    /** @test */
    public function it_can_render_unbound_file_inputs()
    {
        $this->setFrameworkMaterialAdmin26();

        $this->registerTestRoute('file-unbound');

        $this->visit('/file-unbound')
            ->seeElement('div.form-group')
            ->within('div.form-group', function () {
                $this->seeElement('div.fileinput.fileinput-new')
                    ->within('div.fileinput', function () {
                        $this->seeElement('span.btn-file')
                            ->within('span.btn-file', function () {
                                $this->seeElement('input[name="featured_image"][type="file"][accept="application/pdf,image/jpeg,image/png"]#featured_image');
                            });

                        $this->seeElement('span.fileinput-filename')
                            ->within('span.fileinput-filename', function () {
                                $this->dontSeeElement('a');
                            });
                    });
            });
    }

    /** @test */
    public function it_can_render_file_inputs_with_attribute_accessor()
    {
        $article = $this->getArticleWithMedia();

        $this->setFrameworkMaterialAdmin26();

        Route::get('file-attribute-accessor', function () use ($article) {
            return view('file-attribute-accessor')
                ->with('article', $article);
        })->middleware('web');

        $this->visit('/file-attribute-accessor')
            ->seeElement('div.form-group')
            ->within('div.form-group', function () {
                $this->seeElement('div.fileinput.fileinput-exists')
                    ->within('div.fileinput', function () {
                        $this->seeElement('span.btn-file')
                            ->within('span.btn-file', function () {
                                $this->seeElement('input[name="thumbnail"][type="file"][accept="application/pdf,image/jpeg,image/png"]#thumbnail');
                            });

                        $this->seeElement('span.fileinput-filename')
                            ->within('span.fileinput-filename', function () {
                                $this->seeElement('a[href="/storage/1/conversions/some-cool-image-thumb.jpg"]');
                            });
                    });
            });
    }

    /** @test */
    public function it_can_render_file_inputs_with_accessor()
    {
        $article = $this->getArticleWithMedia();

        $this->setFrameworkMaterialAdmin26();

        Route::get('file-accessor', function () use ($article) {
            return view('file-accessor')
                ->with('article', $article);
        })->middleware('web');

        $this->visit('/file-accessor')
            ->seeElement('div.form-group')
            ->within('div.form-group', function () {
                $this->seeElement('div.fileinput.fileinput-exists')
                    ->within('div.fileinput', function () {
                        $this->seeElement('span.btn-file')
                            ->within('span.btn-file', function () {
                                $this->seeElement('input[name="photo"][type="file"][accept="application/pdf,image/jpeg,image/png"]#photo');
                            });

                        $this->seeElement('span.fileinput-filename')
                            ->within('span.fileinput-filename', function () {
                                $this->seeElement('a[href="/storage/1/some-cool-image.jpg"]');
                            });
                    });
            });
    }

    /** @test */
    public function it_can_render_file_inputs_with_conversion_name()
    {
        $article = $this->getArticleWithMedia();

        $this->setFrameworkMaterialAdmin26();

        Route::get('file-conversion', function () use ($article) {
            return view('file-conversion')
                ->with('article', $article);
        })->middleware('web');

        $this->visit('/file-conversion')
            ->seeElement('div.form-group')
            ->within('div.form-group', function () {
                $this->seeElement('div.fileinput.fileinput-exists')
                    ->within('div.fileinput', function () {
                        $this->seeElement('span.btn-file')
                            ->within('span.btn-file', function () {
                                $this->seeElement('input[name="featured_image"][type="file"][accept="application/pdf,image/jpeg,image/png"]#featured_image');
                            });

                        $this->seeElement('span.fileinput-filename')
                            ->within('span.fileinput-filename', function () {
                                $this->seeElement('a[href="/storage/1/conversions/some-cool-image-thumb.jpg"]');
                            });
                    });
            });
    }

    /** @test */
    public function it_can_render_file_inputs_with_collection_name()
    {
        $article = $this->getArticleWithMedia();

        $this->setFrameworkMaterialAdmin26();

        Route::get('file-collection', function () use ($article) {
            return view('file-collection')
                ->with('article', $article);
        })->middleware('web');

        $this->visit('/file-collection')
            ->seeElement('div.form-group')
            ->within('div.form-group', function () {
                $this->seeElement('div.fileinput.fileinput-exists')
                    ->within('div.fileinput', function () {
                        $this->seeElement('span.btn-file')
                            ->within('span.btn-file', function () {
                                $this->seeElement('input[name="post_image"][type="file"][accept="application/pdf,image/jpeg,image/png"]#post_image');
                            });

                        $this->seeElement('span.fileinput-filename')
                            ->within('span.fileinput-filename', function () {
                                $this->seeElement('a[href="/storage/1/some-cool-image.jpg"]');
                            });
                    });
            });
    }

    /** @test */
    public function it_can_show_file_hint()
    {
        $article = $this->getArticleWithMedia();

        $this->setFrameworkMaterialAdmin26();

        Route::get('file-hint', function () use ($article) {
            return view('file-hint')
                ->with('article', $article);
        })->middleware('web');

        $this->visit('/file-hint')
            ->seeElement('div.form-group')
            ->within('div.form-group', function () {
                $this->seeElement('div.fileinput.fileinput-exists')
                    ->within('div.fileinput', function () {
                        $this->seeElement('span.btn-file')
                            ->within('span.btn-file', function () {
                                $this->seeElement('input[name="featured_image"][type="file"][accept="application/pdf,image/jpeg,image/png"]#featured_image');
                            });

                        $this->seeElement('span.fileinput-filename')
                            ->within('span.fileinput-filename', function () {
                                $this->seeElement('a[href="/storage/1/some-cool-image.jpg"]');
                            });
                    });

                $this->seeElement('.form-text')
                    ->seeInElement('.form-text', 'Only .pdf, .jpeg and .png files of max 2MB allowed.');
            });
    }

    /** @test */
    public function it_can_render_material_admin_26_file_inputs()
    {
        $article = $this->getArticleWithMedia();

        $this->setFrameworkMaterialAdmin26();

        Route::get('file', function () use ($article) {
            return view('file')
                ->with('article', $article);
        })->middleware('web');

        $this->visit('/file')
            ->seeElement('div.form-group')
            ->within('div.form-group', function () {
                $this->seeElement('div.fileinput.fileinput-exists')
                     ->within('div.fileinput', function () {
                         $this->seeElement('span.btn-file')
                              ->within('span.btn-file', function () {
                                  $this->seeElement('input[name="featured_image"][type="file"][accept="application/pdf,image/jpeg,image/png"]#featured_image');
                              });

                         $this->seeElement('span.fileinput-filename')
                             ->within('span.fileinput-filename', function () {
                                 $this->seeElement('a[href="/storage/1/some-cool-image.jpg"]')
                                      ->seeElement('i.zmdi.zmdi-open-in-new');
                             });
                     });
            });
    }

    /** @test */
    public function it_can_render_bootstrap_5_file_inputs()
    {
        $article = $this->getArticleWithMedia();

        $this->setFrameworkBootstrap5();

        Route::get('file', function () use ($article) {
            return view('file')
                ->with('article', $article);
        })->middleware('web');

        $this->visit('/file')
            ->seeElement('div.mb-4')
            ->within('div.mb-4', function () {
                $this->seeElement('div.fileinput.fileinput-wrapper.fileinput-exists')
                    ->within('div.fileinput', function () {
                        $this->seeElement('span.btn-file')
                            ->within('span.btn-file', function () {
                                $this->seeElement('input[name="featured_image"][type="file"][accept="application/pdf,image/jpeg,image/png"]#featured_image');
                            });

                        $this->seeElement('a.fileinput-filelink[href="/storage/1/some-cool-image.jpg"]')
                            ->within('a.fileinput-filelink', function () {
                                $this->seeElement('i.fa-regular.fa-arrow-to-bottom');
                            })
                            ->seeElement('button.btn-dismiss')
                            ->within('button.btn-dismiss', function () {
                                $this->seeElement('i.fa-regular.fa-close');
                            });
                    });
            });
    }

    /** @test */
    public function it_can_render_file_upload_inputs()
    {
        $article = $this->getArticleWithMedia();

        $this->setFrameworkBootstrap5();

        Route::get('file-upload', function () use ($article) {
            return view('file-upload')
                ->with('article', $article);
        })->middleware('web');

        $this->visit('/file-upload')
            ->seeElement('div.mb-4')
            ->within('div.mb-4', function () {
                $this->seeElement('div.fileinput.fileinput-wrapper.fileinput-exists')
                    ->within('div.fileinput', function () {
                        $this->seeElement('.upload-btn')
                            ->within('.upload-btn', function () {
                                $this->seeElement('i.fa-regular.fa-arrow-to-top')
                                    ->seeText('Upload file');
                            });
                    });
            });
    }
}
