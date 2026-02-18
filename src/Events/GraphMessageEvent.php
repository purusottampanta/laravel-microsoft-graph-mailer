<?php
namespace Puru\GraphMailer\Events;

class GraphMessageEvent
{
    public function __construct(public array $payload) {}
}
