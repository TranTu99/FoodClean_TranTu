<?php

return [

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // ... Các dịch vụ khác có sẵn của Laravel ...

    // Dán đoạn vnpay của bạn vào ĐUÔI của mảng return này
    'vnpay' => [
        'tmn_code' => env('VNP_TMN_CODE'),
        'hash_secret' => env('VNP_HASH_SECRET'),
        'url' => env('VNP_URL'),
        'return_url' => env('VNP_RETURN_URL'),
    ],

]; // Kết thúc file bằng dấu ];
