<?php

namespace Javaabu\Forms\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use function Laravel\Prompts\multisearch;
use function Laravel\Prompts\confirm;

class PublishViewCommand extends Command
{
    protected $signature = 'forms:publish-view';
    protected $description = 'Interactively publish one or more form view files to your application for customization.';

    public function handle()
    {
        $sourcePath = __DIR__ . '/../../resources/views';
        $targetBase = base_path('resources/views/vendor/forms');
        $filesystem = new Filesystem();
        $finder = new Finder();
        $finder->files()->in($sourcePath);

        $files = [];
        $options = [];
        foreach ($finder as $file) {
            $relativePath = $file->getRelativePathname();
            $files[$relativePath] = $file->getRealPath();
            $targetPath = $targetBase . '/' . $relativePath;
            $label = $relativePath . ($filesystem->exists($targetPath) ? ' (published)' : '');
            $options[$relativePath] = $label;
        }

        if (empty($files)) {
            $this->error('No view files found to publish.');
            return 1;
        }

        $selected = multisearch(
            label: 'Search and select view files to publish:',
            options: fn ($search) => array_filter(
                $options,
                fn ($label) => stripos($label, $search) !== false
            ),
            required: 'You must select at least one file to publish.'
        );

        foreach ($selected as $relativePath) {
            $target = $targetBase . '/' . $relativePath;
            $filesystem->ensureDirectoryExists(dirname($target));
            if ($filesystem->exists($target)) {
                if (!confirm(
                    label: "{$relativePath} already exists. Overwrite?",
                    default: false,
                    yes: 'Overwrite',
                    no: 'Skip',
                    hint: 'If you skip, the existing file will be kept.'
                )) {
                    $this->line("Skipped: {$relativePath}");
                    continue;
                }
            }
            $filesystem->copy($files[$relativePath], $target);
            $this->info("Published: {$relativePath}");
        }

        $this->info('Selected view files published successfully.');
        return 0;
    }
}
