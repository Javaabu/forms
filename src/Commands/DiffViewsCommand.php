<?php

namespace Javaabu\Forms\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class DiffViewsCommand extends Command
{
    protected $signature = 'forms:diff-views
        {--only-redundant : Show only published views that are identical to the package views}';

    protected $description = 'Find redundant or modified published form views in your application.';

    public function handle(): int
    {
        $filesystem = new Filesystem();

        $packagePath  = __DIR__ . '/../../resources/views';
        $publishedPath = resource_path('views/vendor/forms');

        if (! $filesystem->isDirectory($packagePath)) {
            $this->error('Package view directory not found.');
            return 1;
        }

        if (! $filesystem->isDirectory($publishedPath)) {
            $this->info('No published views found in your application.');
            return 0;
        }

        $packageFiles   = $this->getViewFiles($packagePath, $filesystem);
        $publishedFiles = $this->getViewFiles($publishedPath, $filesystem);

        $onlyRedundant = (bool) $this->option('only-redundant');

        $rows = [];
        $counts = [
            'redundant' => 0,
            'modified'  => 0,
        ];

        // ONLY check files in your app, ignore anything not published.
        foreach ($publishedFiles as $relativePath => $publishedRealPath) {

            if (! isset($packageFiles[$relativePath])) {
                // orphan — ignore as per your requirements
                continue;
            }

            $packageContent   = $filesystem->get($packageFiles[$relativePath]);
            $publishedContent = $filesystem->get($publishedRealPath);

            if ($packageContent === $publishedContent) {
                if (! $onlyRedundant) {
                    $rows[] = ['<fg=gray>REDUNDANT</>', $relativePath];
                } else {
                    $rows[] = ['<fg=gray>REDUNDANT</>', $relativePath];
                }
                $counts['redundant']++;
            } else {
                if (! $onlyRedundant) {
                    $rows[] = ['<fg=yellow>MODIFIED</>', $relativePath];
                }
                $counts['modified']++;
            }
        }

        if (empty($rows)) {
            $this->info($onlyRedundant
                ? 'No redundant published views found.'
                : 'No published views match your filters.'
            );

            $this->printSummary($counts);
            return 0;
        }

        $this->table(
            ['Status', 'View'],
            $rows
        );

        $this->printSummary($counts);

        return 0;
    }

    protected function getViewFiles(string $basePath, Filesystem $filesystem): array
    {
        if (! $filesystem->isDirectory($basePath)) {
            return [];
        }

        $files  = [];
        $finder = new Finder();

        $finder->files()->in($basePath)->name('*.blade.php');

        foreach ($finder as $file) {
            $relativePath = str_replace(DIRECTORY_SEPARATOR, '/', $file->getRelativePathname());
            $files[$relativePath] = $file->getRealPath();
        }

        ksort($files);

        return $files;
    }

    protected function printSummary(array $counts): void
    {
        $this->newLine();
        $this->info('Summary:');
        $this->line('  <fg=gray>Redundant (can be deleted):</> '.$counts['redundant']);
        $this->line('  <fg=yellow>Modified (customized override):</> '.$counts['modified']);
    }
}
