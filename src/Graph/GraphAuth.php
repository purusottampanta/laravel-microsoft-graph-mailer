<?php

namespace Puru\GraphMailer\Graph;

class GraphAuth
{
    public function token(array $tenant): string
    {
        return cache()->remember(
            'graph_token_'.$tenant['client_id'],
            now()->addMinutes(50),
            function () use ($tenant) {
                return Http::asForm()
                    ->post(
                        "https://login.microsoftonline.com/{$tenant['tenant_id']}/oauth2/v2.0/token",
                        [
                            'grant_type' => 'client_credentials',
                            'client_id' => $tenant['client_id'],
                            'client_secret' => $tenant['client_secret'],
                            'scope' => 'https://graph.microsoft.com/.default',
                        ]
                    )
                    ->throw()
                    ->json('access_token');
            }
        );
    }
}
