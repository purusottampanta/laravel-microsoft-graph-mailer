<?php

namespace Puru\GraphMailer\Tests;

use Orchestra\Testbench\TestCase;
use Puru\GraphMailer\MicrosoftGraphMailServiceProvider;

abstract class GraphMailerTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [MicrosoftGraphMailServiceProvider::class];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('mail.default', 'microsoft-graph');

        $app['config']->set('mail.mailers.microsoft-graph', [
            'transport' => 'microsoft-graph',
        ]);
    }
}
