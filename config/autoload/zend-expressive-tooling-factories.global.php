<?php
/**
 * This file generated by Zend\Expressive\Tooling\Factory\ConfigInjector.
 *
 * Modifications should be kept at a minimum, and restricted to adding or
 * removing factory definitions; other dependency types may be overwritten
 * when regenerating this file via zend-expressive-tooling commands.
 */

declare(strict_types=1);

return [
    'dependencies' => [
        'factories' => [
            App\Handler\Auth\AuthorizationHandler::class   => App\Handler\Auth\Factory\AuthorizationHandlerFactory::class,
            Auth\Handler\Auth\AuthenticationHandler::class => Auth\Handler\Auth\Factory\AuthenticationHandlerFactory::class,
            Auth\Handler\Login\LoginHandler::class         => Auth\Handler\Login\Factory\LoginHandlerFactory::class,

            User\Handler\Permission\CreatePermissionHandler::class => User\Handler\Permission\Factory\CreatePermissionHandlerFactory::class,
            User\Handler\Permission\GetPermissionHandler::class    => User\Handler\Permission\Factory\GetPermissionHandlerFactory::class,
            User\Handler\Permission\UpdatePermissionHandler::class => User\Handler\Permission\Factory\UpdatePermissionHandlerFactory::class,

            User\Handler\Role\CreateRoleHandler::class => User\Handler\Role\Factory\CreateRoleHandlerFactory::class,
            User\Handler\Role\GetRoleHandler::class    => User\Handler\Role\Factory\GetRoleHandlerFactory::class,
            User\Handler\Role\UpdateRoleHandler::class => User\Handler\Role\Factory\UpdateRoleHandlerFactory::class,
        ],
    ],
];
