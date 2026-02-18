<?php

namespace Puru\GraphMailer\Graph;

use Illuminate\Support\Facades\Http;
use Puru\GraphMailer\Transport\GraphClientInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Envelope;

class GraphClient implements GraphClientInterface
{
    public function __construct(
        private GraphTenantResolver $resolver,
        private GraphAuth $auth,
        private GraphMimeMapper $mapper,
        private GraphRetryPolicy $retry
    ) {}

    public function send(Email $email, Envelope $envelope): void
    {
        $tenant = $this->resolver->resolve($email);
        $payload = [
            'message' => $this->mapper->map($email),
            'saveToSentItems' => true,
        ];

        $this->retry->retry(function () use ($tenant, $payload) {
            $response = Http::withToken($this->auth->token($tenant))
                ->post(
                    "https://graph.microsoft.com/v1.0/users/{$tenant['from']}/sendMail",
                    $payload
                );

            if ($response->failed()) {
                throw new \RuntimeException($response->body());
            }

            return $response;
        });
    }
}
