<?php

declare(strict_types=1);

namespace Auth\Handler\Rbac\Factory;

use Auth\Handler\Rbac\AuthorizationHandler;
use Psr\Container\ContainerInterface;
use Zend\Permissions\Rbac\Rbac;

class AuthorizationHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AuthorizationHandler
    {
        $config = $container->get('config');

        if (! isset($config['rbac']['roles'])) {
            throw new Exception('Rbac roles are not configured');
        }
        if (!isset($config['rbac']['permissions'])) {
            throw new Exception('Rbac permissions are not configured');
        }

        $rbac = new Rbac();
        $rbac->setCreateMissingRoles(true);

        // roles and parents
        foreach ($config['rbac']['roles'] as $role => $parents) {
            $rbac->addRole($role, $parents);
        }

        // permissions
        foreach ($config['rbac']['permissions'] as $role => $permissions) {
            foreach ($permissions as $perm) {
                $rbac->getRole($role)->addPermission($perm);
            }
        }
        return new AuthorizationHandler($rbac);
    }
}
