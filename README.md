## Installation

composer require purusottampanta/laravel-microsoft-graph-mailer

## Publish config
php artisan vendor:publish --tag=microsoft-graph-config

## Configuration
### Add/edit following in .env file
- MAIL_MAILER=microsoft-graph
- MS_TENANT_ID=xxxxxxxxxxx
- MS_CLIENT_ID=xxxxxxxxxxx
- MS_CLIENT_SECRET=xxxxxxxxxxx
- MS_FROM_ADDRESS=xxxxxxxxxxxxx

## Usage
Send Email using Microsoft graph The Laravel Way

Works with:
- Mailables
- Notifications
- Queues
- Cron
- Mail::fake()

No code changes required.

## Register Graph as a mailer (this is the key)
config/mail.php
'mailers' => [

    'microsoft-graph' => [
            'transport' => 'microsoft-graph',
        ],
    'smtp' => [
        'transport' => 'smtp',
        'host' => env('MAIL_HOST'),
        'port' => env('MAIL_PORT'),
        'username' => env('MAIL_USERNAME'),
        'password' => env('MAIL_PASSWORD'),
    ],

    'ses' => [
        'transport' => 'ses',
    ],
],
⚠️ This is the only integration point.
