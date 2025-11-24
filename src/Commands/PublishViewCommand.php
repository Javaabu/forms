<?php

namespace Javaabu\Forms\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use function Laravel\Prompts\select;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;

class PublishViewCommand extends Command
{
    protected $signature = 'forms:publish-view
        {--all : Publish all view files}
        {--force : Overwrite existing files without prompting}';

    protected $description = 'Publish one or more form view files to your application for customization.';

    public function handle()
    {
        $sourcePath = __DIR__ . '/../../resources/views';
        $targetBase = resource_path('views/vendor/forms');
        $filesystem = new Filesystem();

        if (! $filesystem->isDirectory($sourcePath)) {
            $this->error('Source view directory not found.');
            return 1;
        }

        $files = $this->getViewFiles($sourcePath, $filesystem);

        if (empty($files)) {
            $this->error('No view files found to publish.');
            return 1;
        }

        if ($this->option('all')) {
            // publish all files
            $selected = array_keys($files);
        } else {
            // single selection via number
            $selectedIndex = $this->promptForFileSelection($files, $targetBase, $filesystem);

            if ($selectedIndex === null) {
                $this->info('No file selected for publishing.');
                return 0;
            }

            $selected = [$selectedIndex];
        }

        $this->publishFiles($selected, $files, $targetBase, $filesystem);

        return 0;
    }

    protected function getViewFiles(string $sourcePath, Filesystem $filesystem): array
    {
        $files = [];
        $finder = new Finder();

        try {
            $finder->files()->in($sourcePath)->name('*.blade.php');

            $tempFiles = [];
            foreach ($finder as $file) {
                $relativePath = str_replace(DIRECTORY_SEPARATOR, '/', $file->getRelativePathname());
                $tempFiles[$relativePath] = $file->getRealPath();
            }

            ksort($tempFiles);

            $count = 0;
            foreach ($tempFiles as $relativePath => $realPath) {
                $files[$count] = [
                    'relative_path' => $relativePath,
                    'real_path' => $realPath,
                ];
                $count++;
            }
        } catch (\Exception $e) {
            $this->error('Error scanning view files: ' . $e->getMessage());
            return [];
        }

        return $files;
    }

    /**
     * Show a simple numbered list and let the user choose a single file.
     */
    protected function promptForFileSelection(array $files, string $targetBase, Filesystem $filesystem): ?int
    {
        $this->newLine();
        info('Available view files:');

        $options = [];

        foreach ($files as $index => $file) {
            $relative = $file['relative_path'];

            $targetPath = $targetBase . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
            $exists     = $filesystem->exists($targetPath);

            $status = $exists
                ? '<fg=yellow>Published</>'
                : '<fg=green>New</>';

            // Key is the relative path (unique)
            // Label is the filename + status (no numbers)
            $options[$index] = $status . ': ' . $relative;
        }

        $this->newLine();

        // returns the KEY we defined (relative path)
        $selectedRelativePath = select(
            label: 'Which view would you like to publish?',
            options: $options,
        );

        $selected_file = $this->parseChoice($selectedRelativePath);

        // Find the index in the $files array
        $selectedIndex = array_search($selected_file, array_column($files, 'relative_path'), true);

        return $selectedIndex !== false ? $selectedIndex : null;
    }

    public function parseChoice(string $choice)
    {
        [$type, $value] = explode(': ', strip_tags($choice));

        return $value;
    }

    protected function publishFiles(array $selected, array $files, string $targetBase, Filesystem $filesystem): void
    {
        $published = 0;
        $skipped = 0;
        $overwritten = 0;

        foreach ($selected as $fileIndex) {
            if (! isset($files[$fileIndex])) {
                continue;
            }

            $file = $files[$fileIndex];
            $relativePath = $file['relative_path'];
            $sourcePath = $file['real_path'];
            $targetPath = $targetBase . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);

            $filesystem->ensureDirectoryExists(dirname($targetPath));

            $exists = $filesystem->exists($targetPath);

            if ($exists && ! $this->option('force')) {
                $shouldOverwrite = confirm(
                    label: "File {$relativePath} already exists. Overwrite?",
                    default: false,
                    yes: 'Yes, overwrite',
                    no: 'No, skip'
                );

                if (! $shouldOverwrite) {
                    $this->line("  <fg=yellow>SKIPPED</> {$relativePath}");
                    $skipped++;
                    continue;
                }

                $overwritten++;
            }

            try {
                $filesystem->copy($sourcePath, $targetPath);
                $action = $exists ? 'UPDATED' : 'PUBLISHED';
                $this->line("  <fg=green>{$action}</> {$relativePath}");
                $published++;
            } catch (\Exception $e) {
                $this->line("  <fg=red>FAILED</> {$relativePath}: " . $e->getMessage());
            }
        }

        $this->newLine();

        if ($published > 0) {
            $this->info("Successfully published {$published} file(s).");
        }

        if ($overwritten > 0) {
            $this->info("Overwritten {$overwritten} existing file(s).");
        }

        if ($skipped > 0) {
            $this->info("Skipped {$skipped} file(s).");
        }
    }
}
