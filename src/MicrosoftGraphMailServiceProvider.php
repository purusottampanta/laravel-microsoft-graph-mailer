<?php


namespace Puru\GraphMailer;

use Illuminate\Mail\MailManager;
use Illuminate\Support\ServiceProvider;
use Puru\GraphMailer\Transport\MicrosoftGraphTransportFactory;
use Puru\GraphMailer\Transport\MicrosoftGraphTransport;
use Puru\GraphMailer\Transport\GraphClientInterface;
use Puru\GraphMailer\Graph\GraphClient;

class MicrosoftGraphMailServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/microsoft-graph.php',
            'microsoft-graph'
        );

        // $this->app->bind(GraphClientInterface::class, function () {
        //     return new GraphClient(/* config */);
        // });

        $this->app->bind(GraphClientInterface::class, GraphClient::class);
    
    }
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/microsoft-graph.php' => config_path('microsoft-graph.php'),
        ], 'microsoft-graph-config');
    
        // $this->app->make(MailManager::class)->extend(
        //     'microsoft-graph',
        //     function ($config) {
        //         return $this->app->make(\Puru\GraphMailer\Transport\MicrosoftGraphTransport::class);
        //     }
        // );

        $this->app->make(\Illuminate\Mail\MailManager::class)->extend(
            'microsoft-graph',
            function ($config) {
                return new MicrosoftGraphTransport(
                    $this->app->make(GraphClientInterface::class)
                );
            }
        );
        // $this->app->make(MailManager::class)->extend(
        //     'microsoft-graph',
        //     function ($config) {
        //         return new MicrosoftGraphTransport(
        //             // inject dependencies here
        //         );
        //     }
        // );
    }
}