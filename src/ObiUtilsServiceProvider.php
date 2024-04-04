<?php

namespace SchwarzID\ObiUtils;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use SchwarzID\ObiUtils\Commands\ObiUtilsCommand;

class ObiUtilsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('obi-utils')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_obi-utils_table')
            ->hasCommand(ObiUtilsCommand::class);
    }
}
