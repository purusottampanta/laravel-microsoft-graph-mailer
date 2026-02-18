<?php

namespace Puru\GraphMailer\Contracts;

interface ResolvesGraphTenant
{
    public function graphTenant(): string;
}
