<?php

return [

    'default_tenant' => 'default',

    'tenants' => [

        'default' => [
            'tenant_id'     => env('MS_TENANT_ID'),
            'client_id'     => env('MS_CLIENT_ID'),
            'client_secret' => env('MS_CLIENT_SECRET'),
            'from'          => env('MS_FROM_ADDRESS'),
        ],

        'billing' => [
            'tenant_id'     => env('MS_BILLING_TENANT_ID'),
            'client_id'     => env('MS_BILLING_CLIENT_ID'),
            'client_secret' => env('MS_BILLING_CLIENT_SECRET'),
            'from'          => 'billing@company.com',
        ],
    ],
];
