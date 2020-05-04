<?php

declare(strict_types=1);

use Auth\Service\Factory\AuthenticationMiddlewareFactory;
use User\Service\Factory\AuthManagerFactory;

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
            \User\Service\AuthManager::class => AuthManagerFactory::class,
            \Auth\Service\JwtService::class => \Auth\Service\Factory\JwtServiceFactory::class,
            \User\Service\UserManager::class => \User\Service\Factory\UserManagerFactory::class,
            \User\Service\RbacManager::class => \User\Service\Factory\RbacManagerFactory::class,
            \User\Service\RoleManager::class => \User\Service\Factory\RoleManagerFactory::class,
            \Auth\Service\AuthAdapter::class => \Auth\Service\Factory\AuthAdapterFactory::class,
            \User\Service\PermissionManager::class => \User\Service\Factory\PermissionManagerFactory::class,
            'doctrine.entity_manager.orm_default' => \ContainerInteropDoctrine\EntityManagerFactory::class
        ],
    ],
];
