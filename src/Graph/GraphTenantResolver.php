<?php

namespace Puru\GraphMailer\Graph;

use Symfony\Component\Mime\Message;

use Illuminate\Notifications\Notifiable;
use Puru\GraphMailer\Contracts\ResolvesGraphTenant;

class GraphTenantResolver
{
    public function resolve(Message $message, ?object $notifiable = null): array
    {
        // 1️⃣ From Notifiable (highest priority)
        if ($notifiable instanceof ResolvesGraphTenant) {
            return config(
                'microsoft-graph.tenants.' . $notifiable->graphTenant()
            );
        }

        // 2️⃣ From message header
        if ($header = $message->getHeaders()->get('X-Graph-Tenant')) {
            return config(
                'microsoft-graph.tenants.' . $header->getBodyAsString()
            );
        }

        // 3️⃣ Default tenant
        return config(
            'microsoft-graph.tenants.' .
            config('microsoft-graph.default_tenant')
        );
    }
}


// class GraphTenantResolver
// {
//     public function resolve(Message $message): array
//     {
//         $tenant = $message->getHeaders()
//             ->get('X-Tenant')?->getBodyAsString()
//             ?? config('microsoft-graph.default_tenant');

//         return config("microsoft-graph.tenants.$tenant");
//     }
// }
