<?php

declare(strict_types=1);

namespace User\Handler\Permission\Factory;

use Psr\Container\ContainerInterface;
use User\Handler\Permission\GetPermissionHandler;
use User\Handler\Permission\PermissionHandler;

/**
 * Class GetPermissionHandlerFactory
 * @package User\Handler\Permission\Factory
 */
class GetPermissionHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return GetPermissionHandler
     */
    public function __invoke( ContainerInterface $container ) : GetPermissionHandler
    {
        $entityManager = $container->get('doctrine.entity_manager.orm_default');
        return new GetPermissionHandler( $entityManager );
    }
}
