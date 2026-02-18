<?php

namespace Puru\GraphMailer\Tests;

use Puru\GraphMailer\Tests\Fakes\FakeGraphClient;
use Symfony\Component\Mime\Email;
use Puru\GraphMailer\Graph\GraphMimeMapper;
use Puru\GraphMailer\Transport\MicrosoftGraphTransport;
use Symfony\Component\Mime\Part\DataPart;

class MicrosoftGraphTransportTest extends GraphMailerTestCase
{
    public function test_transport_sends_payload()
    {
        // $fake = new FakeGraphClient();

        // $transport = new MicrosoftGraphTransport($fake);

        // $email = (new Email())
        //     ->from('sender@example.com')   
        //     ->to('test@example.com')
        //     ->subject('Hello')
        //     ->html('<b>Hi</b>');

        // $mailer = new \Symfony\Component\Mailer\Mailer($transport);
        // $mailer->send($email);

        // $this->assertCount(1, $fake->sentPayloads);
        // $this->assertEquals('Hello', $fake->sentPayloads[0]['subject']);

        // $this->assertCount(1, $fake->sent);
        // $this->assertEquals('Hello', $fake->sent[0]['email']->getSubject());


        $fakeClient = new FakeGraphClient();
        $transport = new MicrosoftGraphTransport($fakeClient);

        $mailer = new \Symfony\Component\Mailer\Mailer($transport);

        $email = (new \Symfony\Component\Mime\Email())
            ->from('sender@example.com')
            ->to('recipient@example.com')
            ->subject('Hello')
            ->html('<b>Hi</b>');

        $mailer->send($email);

        $this->assertCount(1, $fakeClient->sent);
        $this->assertEquals('Hello', $fakeClient->sent[0]['email']->getSubject());


    }

}