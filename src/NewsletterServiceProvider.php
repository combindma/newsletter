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
            ->hasTranslations();
    }

    public function packageBooted()
    {
        if ($this->app->runningInConsole()) {
            // Export the migration
            if (! class_exists('CreateNewsletterSubscriptionsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_newsletter_subscriptions_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_newsletter_subscriptions_table.php'),
                ], 'newsletter-migrations');
            }
        }
    }

    public function registeringPackage()
    {
        $this->app->singleton('newsletter', function() {
            return new Newsletter();
        });
    }
}
