<?php

namespace Javaabu\Forms\Tests\Unit;

use Illuminate\Support\Facades\Config;
use Javaabu\Forms\Support\MimeTypes;
use Javaabu\Forms\Tests\TestCase;
use Javaabu\Helpers\Media\AllowedMimeTypes;
use PHPUnit\Framework\Attributes\Test;

class MimeTypesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        MimeTypes::$use_helpers = false;
    }

    protected function tearDown(): void
    {
        MimeTypes::$use_helpers = true;

        parent::tearDown();
    }

    #[Test]
    public function it_does_not_require_javaabu_helpers_or_settings(): void
    {
        $composer = json_decode(file_get_contents(__DIR__ . '/../../composer.json'), true);

        $this->assertArrayNotHasKey('javaabu/helpers', $composer['require']);
        $this->assertArrayNotHasKey('javaabu/settings', $composer['require']);
    }

    #[Test]
    public function it_ships_the_same_lists_as_javaabu_helpers(): void
    {
        $types = ['image', 'document', 'pdf', 'excel'];

        foreach ($types as $type) {
            $this->assertEquals(AllowedMimeTypes::getAllowedMimeTypes($type), MimeTypes::mimeTypes($type), $type);
        }

        $mime_types = MimeTypes::mimeTypes($types);

        $this->assertEquals(array_values(AllowedMimeTypes::getExtensions($mime_types)), MimeTypes::extensions($mime_types));
    }

    #[Test]
    public function it_gives_mime_types_and_extensions_for_file_types(): void
    {
        $this->assertContains('image/jpeg', MimeTypes::mimeTypes('image'));
        $this->assertContains('application/pdf', MimeTypes::mimeTypes(['image', 'pdf']));
        $this->assertEquals([], MimeTypes::mimeTypes('not-a-type'));
        $this->assertEquals(['jpeg', 'png'], MimeTypes::extensions(['image/jpeg', 'image/png', 'unknown/type']));
    }

    #[Test]
    public function it_reads_the_max_file_size_from_the_forms_config_without_settings(): void
    {
        $this->assertGreaterThan(0, MimeTypes::maxFileSize('document'));

        Config::set('forms.defaults.max_upload_file_size', 2048);

        $this->assertEquals(2048, MimeTypes::maxFileSize('document'));
        $this->assertEquals('max_image_file_size', MimeTypes::fileSizeSetting('image'));
        $this->assertEquals('max_upload_file_size', MimeTypes::fileSizeSetting('document'));
    }

    #[Test]
    public function it_formats_file_sizes_with_translated_units(): void
    {
        $this->assertEquals('512KB', MimeTypes::formatFileSize(512));
        $this->assertEquals('1.5MB', MimeTypes::formatFileSize(1536));
        $this->assertEquals('2GB', MimeTypes::formatFileSize(2 * 1024 * 1024));
    }

    #[Test]
    public function apps_can_register_their_own_types(): void
    {
        MimeTypes::register('ebook', ['application/epub+zip']);
        MimeTypes::registerExtensions(['application/epub+zip' => 'epub']);

        $this->assertEquals(['application/epub+zip'], MimeTypes::mimeTypes('ebook'));
        $this->assertEquals(['epub'], MimeTypes::extensions(['application/epub+zip']));

        $html = $this->renderBlade('<x-forms::file name="book" type="ebook" :max-size="1024" :model="false" />');

        $this->assertEquals('application/epub+zip', $html->filter('input[type="file"]')->attr('accept'));
        $this->assertStringContainsString('.epub', $html->text());
    }

    #[Test]
    public function file_inputs_render_their_default_hint_without_a_global_format_file_size(): void
    {
        $html = $this->renderBlade('<x-forms::file name="file" :label="__(\'File\')" :extensions="[\'csv\', \'xlsx\']" :max-size="51200" :model="false" />');

        $this->assertStringContainsString('Only .csv and .xlsx files of max 50MB allowed.', $html->text());

        app()->setLocale('dv');

        $html = $this->renderBlade('<x-forms::file name="file" :extensions="[\'csv\']" :max-size="512" :model="false" />');

        $this->assertStringContainsString('ހަމައެކަނި .csv ވައްތަރުގެ 512KB', $html->text());
    }
}
