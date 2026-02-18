<?php

namespace Puru\GraphMailer\Tests\Fakes;

use Puru\GraphMailer\Transport\GraphClientInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Envelope;

class FakeGraphClient implements GraphClientInterface
{
    public array $sent = [];

    public function send(Email $email, Envelope $envelope): void
    {
        // Save payload for inspection in tests
        $this->sent[] = [
            'email' => $email,
            'envelope' => $envelope,
        ];
    }
}
