<?php

namespace SchwarzID\ObiUtils;

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

    public function packageRegistered(): void
    {
        $this->app->bind(ObiUtils::class, function () {
            return new ObiUtils;
        });
    }
}
