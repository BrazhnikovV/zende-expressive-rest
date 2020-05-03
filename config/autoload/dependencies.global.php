<?php

declare(strict_types=1);

use App\Service\Factory\AuthenticationMiddlewareFactory;
use App\Service\Factory\AuthorizationMiddlewareFactory;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'aliases' to alias a service name to another service. The
        // key is the alias name, the value is the service to which it points.
        'aliases' => [
            // Fully\Qualified\ClassOrInterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories'  => [
            \App\Service\AuthAdapter::class => \App\Service\Factory\AuthAdapterFactory::class,
            \Mezzio\Authentication\AuthenticationMiddleware::class => AuthenticationMiddlewareFactory::class,
            \App\Service\AuthorizationAdapter::class => \App\Service\Factory\AuthorizationAdapterFactory::class,
            \Mezzio\Authorization\AuthorizationMiddleware::class => AuthorizationMiddlewareFactory::class
        ],
    ],
];
