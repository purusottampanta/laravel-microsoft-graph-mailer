<?php

namespace Puru\GraphMailer\Transport;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Envelope;

interface GraphClientInterface
{
    public function send(Email $email, Envelope $envelope): void;
}