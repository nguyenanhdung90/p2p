<?php

use App\Models\FiatInfo;

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'coin_infos' => [
        [
            ["currency" => "TON"],
            ["decimals" => 9]
        ],
        [
            ["currency" => "USDT"],
            [
                "name" => "Tether USD",
                "description" => "Tether Token for Tether USD",
                "image" => "https://tether.to/images/logoCircle.png",
                "decimals" => 6,
            ]
        ],
        [
            ["currency" => "NOT"],
            [
                "name" => "Notcoin",
                "image" => "https://cdn.joincommunity.xyz/clicker/not_logo.png",
                "decimals" => 9,
            ]
        ],
        [
            ["currency" => "PAYN"],
            ["decimals" => 9],
        ],
        [
            ["currency" => "BTC"],
            [
                "decimals" => 8,
                "name" => "Bitcoin"
            ],
        ]
    ],
    'fiat_infos' => [
        [
            ["currency" => FiatInfo::FIAT_USD],
            [
                "decimals" => 2,
                "description" => "United States dollar",
                "name" => "United States dollar"
            ]
        ],
        [
            ["currency" => FiatInfo::FIAT_VND],
            [
                "decimals" => 0,
                "description" => "Vietnamese dong",
                "name" => "Vietnamese dong"
            ]
        ]
    ],
    "default_max_length_string" => 191
];
