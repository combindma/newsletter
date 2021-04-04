<?php

namespace Combindma\Newsletter;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NewsletterServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('newsletter')
            ->hasConfigFile('newsletter')
            ->hasViews()
            ->hasMigration('create_newsletter_subscriptions_table');
    }
}
