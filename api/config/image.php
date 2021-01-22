<?php
/**
 * Image repository configuration.
 */
return [

    // The default provider for the application, must match one of the keys in the 'providers' array below
    'default_provider' => env('DEFAULT_IMAGE_PROVIDER', 'pexels'),

    // Providers and their individual settings
    'providers' => [
        'unsplash' => [
            'client_id'   => env('UNSPLASH_CLIENT_ID'),
            'attribution' => '<a href="https://unsplash.com/?utm_source=timeout_drink_water_reminder&utm_medium=referral">Unsplash</a>',
        ],

        'pexels' => [
            'client_id'   => env('PEXELS_API_KEY'),
            'base_url'    => env('PEXELS_API_URL'),
            'attribution' => '<a href="https://www.pexels.com"><img src="https://images.pexels.com/lib/api/pexels.png" alt="Pexels Logo"/></a>',
        ],

        // Other provider
        //'other' => [
        //        'client_id' => '',
        //        'attribution' => '',
        // ],
    ],
];
