<?php

namespace Puru\GraphMailer\Graph;

class GraphRetryPolicy
{
    public function retry(callable $fn)
    {
        retry(
            5,
            function () use ($fn) {
                $response = $fn();

                if ($response->status() === 429) {
                    throw new \RuntimeException('Graph throttled');
                }

                $response->throw();
            },
            function ($attempt, $exception) {
                return 2 ** $attempt * 1000; // exponential backoff
            }
        );
    }
}
