<?php

namespace Combindma\Newsletter\Tests;

use Combindma\Newsletter\Http\Controllers\NewsletterController;
use Combindma\Newsletter\NewsletterServiceProvider;
use Elegant\Sanitizer\Laravel\SanitizerServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;
use Propaganistas\LaravelDisposableEmail\DisposableEmailServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Combindma\\Newsletter\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        //$this->withoutExceptionHandling();
    }

    protected function getPackageProviders($app)
    {
        return [
            NewsletterServiceProvider::class,
            SanitizerServiceProvider::class,
            DisposableEmailServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        //Schema::dropAllTables(); //run MYSQL server by this command: brew services start mysql

        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        include_once __DIR__.'/../database/migrations/create_newsletter_subscriptions_table.php.stub';
        (new \CreateNewsletterSubscriptionsTable())->up();
    }

    protected function defineRoutes($router)
    {
        Route::group(['as' => 'newsletter::', 'middleware' => ['bindings']], function () {
            Route::resource('newsletter', NewsletterController::class)->except(['show'])->parameters(['newsletter' => 'subscriber']);
            Route::post('/newsletter/{id}/restore', [NewsletterController::class, 'restore'])->name('newsletter.restore');
        });
    }
}
