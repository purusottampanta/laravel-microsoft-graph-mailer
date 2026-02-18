<?php

namespace Puru\GraphMailer\Tests;

use Symfony\Component\Mime\Email;
use Puru\GraphMailer\Graph\GraphMimeMapper;
use Puru\GraphMailer\Transport\MicrosoftGraphTransport;
use Symfony\Component\Mime\Part\DataPart;

class GraphMimeMapperTest extends GraphMailerTestCase
{

    public function test_maps_html_and_recipients()
    {
        $email = (new Email())
            ->to('a@test.com')
            ->cc('b@test.com')
            ->subject('Hello')
            ->html('<b>Hi</b>');

        $mapper = new GraphMimeMapper();
        $graph = $mapper->map($email);

        $this->assertEquals('Hello', $graph['subject']);
        $this->assertCount(1, $graph['toRecipients']);
        $this->assertCount(1, $graph['ccRecipients']);
        $this->assertEquals('HTML', $graph['body']['contentType']);
    }

    public function test_inline_image_mapping()
    {
        $email = (new Email())
            ->html('<img src="cid:logo.png">')
            ->embedFromPath(__DIR__.'/fixtures/logo.png', 'logo.png');

        $graph = (new GraphMimeMapper())->map($email);

        $this->assertTrue($graph['attachments'][0]['isInline']);
    }

    public function test_inline_image_mapping_withdatapart()
    {
        $email = (new Email())
            ->html('<img src="cid:logo.png@local">');

        $part = new DataPart(
            'fake-image-content',
            'logo.png',
            'image/png'
        );

        $part->asInline();
        $part->setContentId('logo.png@local');

        $email->addPart($part);

        $graph = (new GraphMimeMapper())->map($email);

        $this->assertTrue($graph['attachments'][0]['isInline']);
    }

    public function test_transport_is_registered()
    {
        $this->assertInstanceOf(
            \Puru\GraphMailer\Transport\MicrosoftGraphTransport::class,
            app('mailer')->getSymfonyTransport()
        );
    }


}
