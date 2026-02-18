## Installation

composer require Puru/laravel-microsoft-graph-mailer

## Configuration

MAIL_MAILER=graph

## Usage

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

    'graph' => [
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
