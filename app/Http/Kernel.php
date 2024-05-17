<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [

    ];
    protected $middlewareGroups = [
        'web' => [
            // Middleware for web routes...
        ],

        'api' => [
            // Middleware for API routes...
        ],
    ];
    protected $routeMiddleware = [

        'cors' => \App\Http\Middleware\HandleCors::class,
    ];
}
