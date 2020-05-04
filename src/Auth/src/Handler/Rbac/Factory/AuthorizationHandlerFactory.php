<?php

declare(strict_types=1);

namespace Auth\Handler\Rbac\Factory;

use Auth\Handler\Rbac\AuthorizationHandler;
use Psr\Container\ContainerInterface;
use User\Service\RbacManager;
use Zend\Permissions\Rbac\Rbac;

class AuthorizationHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AuthorizationHandler
    {
        $rbacManager = $container->get(RbacManager::class);
        return new AuthorizationHandler($rbacManager);
    }
}
