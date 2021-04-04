<?php

namespace Combindma\Newsletter;

use Combindma\Newsletter\Http\Controllers\NewsletterController;
use Combindma\Newsletter\Models\NewsletterSubscription;
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

    public static function create(array $data)
    {
        NewsletterSubscription::create($data);
        //TODO: Add mailchimp integration
        /*$list_id = config('newsletter.listId');
        $MailChimp = new MailChimp(config('newsletter.apiKey'));
        $MailChimp->post("lists/$list_id/members", [
            'email_address' => $request->input('email'),
            'status'        => 'subscribed',
        ]);*/
    }
}
