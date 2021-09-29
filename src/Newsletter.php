<?php

namespace Combindma\Newsletter;

use Combindma\Newsletter\Http\Controllers\NewsletterController;
use Combindma\Newsletter\Models\NewsletterSubscription;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\CreateContact;

class Newsletter
{
    protected $apiKey;
    protected $apiEnabled;
    protected $baseUri = 'https://api.sendinblue.com/v3';

    public function __construct()
    {
        $this->apiEnabled = config('newsletter.api_enabled');
        $this->apiKey = config('newsletter.apiKey');
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function apiIsNotEnabled()
    {
        return !$this->apiEnabled;
    }

    public function create(array $data, array $listIds)
    {
        $email = NewsletterSubscription::create($data)->email;
        $apiData = [
            'email' => $email,
            'listIds' => $listIds,
        ];
        $this->addContact($apiData);
    }

    public function addContact(array $apiData)
    {
        if ($this->apiIsNotEnabled())
        {
            return null;
        }
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->getApiKey());
        $apiInstance = new ContactsApi(
            new Client(),
            $config
        );
        $createContact = new CreateContact();
        $createContact['email'] = $apiData['email'];
        $createContact['listIds'] = $apiData['listIds'];
        $createContact['updateEnabled'] = true;

        try {
            $apiInstance->createContact($createContact);
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    public function routes(string $prefix = 'dash')
    {
        Route::group(['prefix' => $prefix, 'as' => 'newsletter::'], function () {
            Route::resource('newsletter', NewsletterController::class)->except(['show'])->parameters(['newsletter' => 'subscriber']);
            Route::post('/newsletter/{id}/restore', [NewsletterController::class, 'restore'])->name('newsletter.restore');
        });
    }
}
