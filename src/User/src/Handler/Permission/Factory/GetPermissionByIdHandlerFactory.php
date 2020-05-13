<?php

declare(strict_types=1);

namespace User\Handler\Permission\Factory;

use Psr\Container\ContainerInterface;
use User\Handler\Permission\GetPermissionByIdHandler;

/**
 * Class GetPermissionByIdHandlerFactory
 * @package User\Handler\Permission\Factory
 */
class GetPermissionByIdHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return GetPermissionByIdHandler
     */
    public function __invoke( ContainerInterface $container ) : GetPermissionByIdHandler
    {
        $entityManager = $container->get('doctrine.entity_manager.orm_default');
        return new GetPermissionByIdHandler( $entityManager );
    }
}
