<?php


namespace Puru\GraphMailer\Transport;

class MicrosoftGraphTransportFactory
{
    public function __invoke()
    {
        return app(MicrosoftGraphTransport::class);
    }
}