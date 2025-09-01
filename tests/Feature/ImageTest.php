<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Javaabu\Forms\Tests\TestSupport\Models\Article;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ImageTest extends TestCase
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



    #[Test]
    public function it_can_render_bootstrap_5_image_inputs()
    {
        $article = $this->getArticleWithMedia();

        $this->setFrameworkBootstrap5();

        Route::get('image', function () use ($article) {
            return view('image')
                ->with('article', $article);
        })->middleware('web');

        $this->visit('/image')
            ->seeElement('div.mb-4')
            ->within('div.mb-4', function () {
                $this->seeElement('div.fileinput.fileinput-exists')
                    ->seeElement('div.fileinput-wrapper')
                    ->within('div.fileinput-wrapper', function () {
                        $this->seeElement('span.btn-file')
                            ->within('span.btn-file', function () {
                                $this->seeElement('input[name="featured_image"][type="file"][accept="image/jpeg,image/png,image/gif,image/tiff,image/x-citrix-png,image/x-png,image/svg+xml,image/svg"]#featured_image');
                            });
                    })
                    ->seeElement('div.fileinput-preview')
                    ->within('div.fileinput-preview', function () {
                        $this->seeElement('img[src="/storage/1/some-cool-image.jpg"]');
                    })
                    ->seeElement('.fileinput-image-missing')
                    ->within('.fileinput-image-missing', function () {
                        $this->seeElement('i.fa-regular.fa-image');
                    })
                    ->seeElement('button[data-dismiss="fileinput"]')
                    ->seeInElement('button[data-dismiss="fileinput"]', 'Remove')
                    ->seeElement('.fileinput-image-missing')
                    ->seeInElement('.fileinput-image-missing', 'Click to select an image')
                    ->seeElement('.form-text')
                    ->seeInElement('.form-text', 'Recommended 500px x 500px.');
            });
    }

    #[Test]
    public function it_can_render_material_admin_26_image_inputs()
    {
        $article = $this->getArticleWithMedia();

        $this->setFrameworkMaterialAdmin26();

        Route::get('image', function () use ($article) {
            return view('image')
                ->with('article', $article);
        })->middleware('web');

        $this->visit('/image')
            ->seeElement('div.form-group')
            ->within('div.form-group', function () {
                $this->seeElement('div.fileinput.fileinput-exists')
                    ->within('div.fileinput', function () {
                        $this->seeElement('span.btn-file')
                            ->within('span.btn-file', function () {
                                $this->seeElement('input[name="featured_image"][type="file"][accept="image/jpeg,image/png,image/gif,image/tiff,image/x-citrix-png,image/x-png,image/svg+xml,image/svg"]#featured_image');
                            });
                    })
                    ->seeElement('div.fileinput-preview')
                    ->within('div.fileinput-preview', function () {
                        $this->seeElement('img[src="/storage/1/some-cool-image.jpg"]');
                    })
                    ->seeElement('.fileinput-image-missing')
                    ->within('.fileinput-image-missing', function () {
                        $this->seeElement('i.zmdi.zmdi-image');
                    })
                    ->seeElement('a[data-dismiss="fileinput"]')
                    ->seeInElement('a[data-dismiss="fileinput"]', 'Remove')
                    ->seeElement('.fileinput-image-missing')
                    ->seeInElement('.fileinput-image-missing', 'Click to select an image')
                    ->seeElement('.form-text')
                    ->seeInElement('.form-text', 'Recommended 500px x 500px.');
            });
    }

    #[Test]
    public function it_can_render_image_upload_inputs()
    {
        $article = $this->getArticleWithMedia();

        $this->setFrameworkBootstrap5();

        Route::get('image-upload', function () use ($article) {
            return view('image-upload')
                ->with('article', $article);
        })->middleware('web');

        $this->visit('/image-upload')
            ->seeElement('div.mb-4')
            ->within('div.mb-4', function () {
                $this->seeElement('div.fileinput.fileinput-exists')
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
