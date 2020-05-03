<?php

namespace App\Cors;

use Tuupola\Middleware\CorsMiddleware;

class CorsMiddlewareFactory
{
    public function __invoke($container)
    {
        $corsConfig = $container->get('config')['cors'] ?? [];
        return new CorsMiddleware($corsConfig);
    }
}
