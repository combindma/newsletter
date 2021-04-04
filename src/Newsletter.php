<?php

namespace Combindma\Newsletter;

use Combindma\Newsletter\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Route;

class Newsletter
{
    public static function routes(string $prefix = 'dash')
    {
        Route::group(['prefix' => $prefix, 'as' => 'newsletter::'], function (){
            Route::resource('newsletter', NewsletterController::class)->except(['show'])->parameters(['newsletter' => 'subscriber']);
            Route::post('/newsletter/{id}/restore', [NewsletterController::class, 'restore'])->name('newsletter.restore');
        });
    }
}
