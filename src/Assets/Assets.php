<?php

namespace Javaabu\Forms\Assets;

use Javaabu\Manifest\Enums\NpmScopes;
use Javaabu\Manifest\Package;

/**
 * The package's frontend assets, registered with javaabu/manifest.
 *
 * This is the only place that knows manifest's registration API; components only
 * name the assets they need (see Component::assets()).
 */
class Assets
{
    public const string PACKAGE = 'forms';

    /**
     * Core behaviours: conditional display, select all, submit spinner, focus on
     * error, Thaana, and the Onu dialog, tab and alert widgets.
     */
    public const string CORE = 'forms';

    public const string SELECT = 'select';

    public const string DATES = 'dates';

    public const string FILES = 'files';

    public const string WYSIWYG = 'wysiwyg';

    /**
     * Tailwind, Onu and the forms styles in one stylesheet, for apps that don't
     * import resources/css/onu.css into their own Tailwind build.
     */
    public const string ONU_STYLES = 'onu';

    public static function register(Package $package): void
    {
        $package
            // Not @javaabu/forms: that's the React package's npm name.
            ->js('js')
            ->alias('@javaabu/forms-blade')
            ->dist('../dist')
            ->style(self::ONU_STYLES, 'css/onu-standalone.css')
            ->style('select-styles', 'css/select.css')
            ->style('dates-styles', 'css/dates.css')
            ->script(self::CORE, 'js/forms.ts')
            ->script(self::SELECT, 'js/select.ts', depends_on: [self::id(self::CORE), self::id('select-styles')])
            ->script(self::DATES, 'js/dates.ts', depends_on: [self::id(self::CORE), self::id('dates-styles')])
            ->script(self::FILES, 'js/files.ts', depends_on: [self::id(self::CORE)])
            ->script(self::WYSIWYG, 'js/wysiwyg.ts', depends_on: [self::id(self::CORE)])
            // Only what the Blade scripts and styles above import. Apps importing
            // @javaabu/forms-blade get the same files, and forms has no Inertia pages,
            // so nothing is pages-only: the React @javaabu/forms isn't needed at all.
            ->npm([
                'flatpickr' => '^4.6',
                'tom-select' => '^2.4',
            ], [
                '@javaabu/onu' => '^0.2.1',
                'tailwindcss' => '^4.0',
                // @javaabu/onu/thaana (imported by js/thaana.ts) also exports React hooks, so
                // the build must resolve "react" even though none of it ends up in the bundle.
                'react' => '^19.0',
            ], for: NpmScopes::ASSETS);
    }

    public static function id(string $name): string
    {
        return self::PACKAGE . '::' . $name;
    }

    /**
     * Asset ids for the given names, honouring the forms.assets config.
     *
     * @param  array<int, string>  $names
     * @return array<int, string>
     */
    public static function ids(array $names, string $framework): array
    {
        if (! config('forms.assets.enabled', true)) {
            return [];
        }

        if ($framework === 'onu' && config('forms.assets.styles', true)) {
            $names[] = self::ONU_STYLES;
        }

        return array_values(array_unique(array_map(self::id(...), $names)));
    }
}
