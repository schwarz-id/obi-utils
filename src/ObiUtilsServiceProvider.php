<?php

namespace SchwarzID\ObiUtils;

use SchwarzID\ObiUtils\Commands\ObiUtilsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasConfigFile();
    }
}
