<?php

use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies as Middleware; // (en Laravel 12 es Illuminate\Http\Middleware\TrustProxies)

class TrustProxies extends Middleware
{
    protected $proxies = '*'; // confía en ngrok
    protected $headers = Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO | Request::HEADER_X_FORWARDED_AWS_ELB;
}
