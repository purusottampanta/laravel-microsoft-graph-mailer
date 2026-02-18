<?php

namespace Puru\GraphMailer\Transport;

use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Email;
use Puru\GraphMailer\Graph\GraphMimeMapper;

class MicrosoftGraphTransport extends AbstractTransport
{
    protected GraphClientInterface $client;
    protected GraphMimeMapper $mapper;

    public function __construct(GraphClientInterface $client)
    {
        parent::__construct();

        $this->client = $client;
        $this->mapper = new GraphMimeMapper();
    }

    protected function doSend(SentMessage $message): void
    {
        $original = $message->getOriginalMessage();

        $envelope = $message->getEnvelope();

        if (! $original instanceof Email) {
            throw new \RuntimeException('Microsoft Graph transport only supports Email messages.');
        }

        $payload = $this->mapper->map($original);

        try {
            $this->client->send($original,$envelope);
            // $this->client->send($payload,$envelope);
        } catch (\Throwable $e) {
            throw new \RuntimeException(
                'Microsoft Graph send failed: '.$e->getMessage(),
                0,
                $e
            );
        }
    }

    public function __toString(): string
    {
        return 'microsoft-graph';
    }
}
