<?php

declare(strict_types=1);

namespace User\Handler\Role\Factory;

use Psr\Container\ContainerInterface;
use User\Handler\Role\GetRoleByIdHandler;

/**
 * Class GetRoleByIdHandlerFactory
 * @package User\Handler\Role\Factory
 */
class GetRoleByIdHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return GetRoleByIdHandler
     */
    public function __invoke( ContainerInterface $container ) : GetRoleByIdHandler
    {
        $entityManager = $container->get('doctrine.entity_manager.orm_default');
        return new GetRoleByIdHandler( $entityManager );
    }
}
