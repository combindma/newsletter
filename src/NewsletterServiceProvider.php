<?php

namespace Combindma\Newsletter;

use Combindma\Newsletter\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NewsletterServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('newsletter')
            ->hasConfigFile('newsletter')
            ->hasViews()
            ->hasTranslations()
            ->hasMigration('create_newsletter_subscriptions_table');
    }

    public function packageRegistered()
    {
        Route::macro('newsletter', function (string $baseUrl = 'admin') {
            Route::group(['prefix' => $baseUrl, 'as' => 'newsletter::'], function () {
                Route::resource('newsletter', NewsletterController::class)->except(['show'])->parameters(['newsletter' => 'subscriber']);
                Route::post('/newsletter/{id}/restore', [NewsletterController::class, 'restore'])->name('newsletter.restore');
            });
        });
    }
}
