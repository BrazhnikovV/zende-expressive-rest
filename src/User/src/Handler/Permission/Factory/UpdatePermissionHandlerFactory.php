<?php

declare(strict_types=1);

namespace User\Handler\Permission\Factory;

use User\Filter\FormErrorFilter;
use User\Service\PermissionManager;
use Psr\Container\ContainerInterface;
use User\Handler\Permission\UpdatePermissionHandler;

/**
 * Class UpdatePermissionHandlerFactory
 * @package User\Handler\Permission\Factory
 */
class UpdatePermissionHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return UpdatePermissionHandler
     */
    public function __invoke( ContainerInterface $container ) : UpdatePermissionHandler
    {
        $permissionManager = $container->get( PermissionManager::class );
        $entityManager     = $container->get('doctrine.entity_manager.orm_default');

        return new UpdatePermissionHandler( $permissionManager, new FormErrorFilter(), $entityManager );
    }
}
