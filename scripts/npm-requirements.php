<?php

/*
 * Prints the npm packages a Blade app must install to build javaabu/forms' assets
 * (manifest's "assets" scope), one `name@constraint` per line, from Assets::register().
 *
 * CI installs exactly these into an empty app and builds the Blade sources
 * (scripts/blade-app-build.sh), so a package the sources need but forms doesn't
 * declare fails the build instead of an app's.
 */

use Javaabu\Forms\Assets\Assets;
use Javaabu\Manifest\Enums\NpmScopes;
use Javaabu\Manifest\Package;

require __DIR__ . '/../vendor/autoload.php';

$package = new Package(Assets::PACKAGE, __DIR__ . '/../resources');

Assets::register($package);

$requirements = [
    ...$package->npmDependencies(NpmScopes::ASSETS),
    ...$package->npmPeerDependencies(NpmScopes::ASSETS),
];

ksort($requirements);

foreach ($requirements as $name => $constraint) {
    echo "{$name}@{$constraint}\n";
}
