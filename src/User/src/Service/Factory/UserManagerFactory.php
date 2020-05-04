<?php
namespace User\Service\Factory;

use User\Service\UserManager;
use User\Service\RoleManager;
use User\Service\PermissionManager;
use Interop\Container\ContainerInterface;

/**
 * This is the factory class for UserManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class UserManagerFactory
{
    /**
     * This method creates the UserManager service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entity_manager.orm_default');
        $roleManager = $container->get(RoleManager::class);
        $permissionManager = $container->get(PermissionManager::class);
        $config = $container->get('config');

        return new UserManager($entityManager, $roleManager, $permissionManager, $config);
    }
}
