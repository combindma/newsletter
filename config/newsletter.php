<?php

return [

    /*
   * Enable or disable Sendinblue. Useful for local development when runing tests.
   */
    'api_enabled' => env('SENDINBLUE_ENABLED', false),

    'apiKey' => env('SENDINBLUE_APIKEY'),
];
