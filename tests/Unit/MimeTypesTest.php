<?php

namespace Javaabu\Forms\Tests\Unit;

use Illuminate\Support\Facades\Config;
use Javaabu\Forms\Support\MimeTypes;
use Javaabu\Forms\Tests\TestCase;
use Javaabu\Forms\Tests\TestSupport\FakeSettings;
use Javaabu\Helpers\Media\AllowedMimeTypes;
use PHPUnit\Framework\Attributes\Test;

class MimeTypesTest extends TestCase
{
    #[Test]
    public function it_does_not_require_javaabu_helpers_or_settings(): void
    {
        $composer = json_decode(file_get_contents(__DIR__ . '/../../composer.json'), true);

        $this->assertArrayNotHasKey('javaabu/helpers', $composer['require']);
        $this->assertArrayNotHasKey('javaabu/settings', $composer['require']);
    }

    #[Test]
    public function it_tests_without_javaabu_helpers_or_settings(): void
    {
        $composer = json_decode(file_get_contents(__DIR__ . '/../../composer.json'), true);

        // helpers v1 can't install next to settings v2, and settings v2 requires forms (#20).
        $this->assertArrayNotHasKey('javaabu/helpers', $composer['require-dev']);
        $this->assertArrayNotHasKey('javaabu/settings', $composer['require-dev']);
        $this->assertFalse(class_exists(AllowedMimeTypes::class));
    }

    #[Test]
    public function it_ships_the_types_javaabu_helpers_had(): void
    {
        $data = require __DIR__ . '/../../resources/data/mime-types.php';

        $this->assertEquals(
            ['image', 'icon', 'video', 'audio', 'excel', 'word', 'powerpoint', 'pdf', 'text', 'json', 'document', 'zip'],
            array_keys($data['mime_types']),
        );
        $this->assertCount(186, $data['extensions']);
        $this->assertEquals(['application/pdf', 'image/jpeg', 'image/png'], MimeTypes::mimeTypes('document'));
        $this->assertContains('application/msword', MimeTypes::mimeTypes('word'));
        $this->assertEquals(['docx', 'xlsx'], MimeTypes::extensions([
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]));
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
    public function it_reads_the_max_file_size_from_settings(): void
    {
        FakeSettings::$values = [
            'max_upload_file_size' => 4096,
            'max_image_file_size' => 1024,
            'max_pdf_file_size' => 8192,
        ];

        $this->assertEquals(4096, MimeTypes::maxFileSize('document'));
        $this->assertEquals(1024, MimeTypes::maxFileSize('image'));
        $this->assertEquals(1024, MimeTypes::maxFileSize('icon'));
        $this->assertEquals(8192, MimeTypes::maxFileSize(['image', 'pdf']));

        $html = $this->renderBlade('<x-forms::file name="photo" type="image" :model="false" />');

        $this->assertStringContainsString('1MB', $html->text());
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
