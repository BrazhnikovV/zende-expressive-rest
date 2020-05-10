<?php

declare(strict_types=1);

namespace User\Handler\Permission\Factory;

use User\Filter\FormErrorFilter;
use User\Service\PermissionManager;
use Psr\Container\ContainerInterface;
use User\Handler\Permission\CreatePermissionHandler;

/**
 * Class CreatePermissionHandlerFactory
 * @package User\Handler\Permission\Factory
 */
class CreatePermissionHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return CreatePermissionHandler
     */
    public function __invoke( ContainerInterface $container ) : CreatePermissionHandler
    {
        $entityManager     = $container->get('doctrine.entity_manager.orm_default');
        $permissionManager = $container->get( PermissionManager::class );

        return new CreatePermissionHandler( $permissionManager, new FormErrorFilter(), $entityManager );
    }
}
