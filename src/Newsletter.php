<?php

namespace Combindma\Newsletter;

use Combindma\Newsletter\Models\NewsletterSubscription;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
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

    public function create(array $data, array $listIds = [], array $attributes = [])
    {
        NewsletterSubscription::updateOrCreate(
            ['email' => $data['email']],
            $data
        );
        if (!empty($listIds))
        {
            $apiData = [
                'email' => $data['email'],
                'listIds' => $listIds,
                'attributes' => $attributes
            ];
            $this->addContact($apiData);
        }
    }

    public function addContact(array $apiData)
    {
        if ($this->apiIsNotEnabled()) {
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
        if (!empty($apiData['attributes'])) {
            $createContact['attributes'] = $apiData['attributes'];
        }

        try {
            $apiInstance->createContact($createContact);
        } catch (Exception $e) {
            Log::error($e);
        }
    }
}
