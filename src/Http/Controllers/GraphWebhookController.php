<?php

namespace Puru\GraphMailer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GraphWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Validation handshake
        if ($request->has('validationToken')) {
            return response($request->query('validationToken'), 200);
        }

        foreach ($request->input('value', []) as $event) {
            event(new \Puru\GraphMailer\Events\GraphMessageEvent($event));
        }

        return response()->noContent();
    }
}
