<?php

namespace Vendor\GraphMailer\Contracts;

interface ResolvesGraphTenant
{
    public function graphTenant(): string;
}
