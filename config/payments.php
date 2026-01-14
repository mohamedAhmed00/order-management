<?php

return [

    /*
    |--------------------------------------------------------------------------
    | For payment gateways
    |--------------------------------------------------------------------------
    */
    'gateways' => [
        'credit_card' => [
            'api_key' => env('CC_API_KEY'),
        ],
        'paypal' => [
            'client_id' => env('PAYPAL_CLIENT_ID'),
            'secret' => env('PAYPAL_SECRET'),
        ],
    ],

];
