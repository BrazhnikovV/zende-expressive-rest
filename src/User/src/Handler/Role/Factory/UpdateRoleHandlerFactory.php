<?php

declare(strict_types=1);

namespace User\Handler\Role\Factory;

use User\Service\RoleManager;
use User\Filter\FormErrorFilter;
use Psr\Container\ContainerInterface;
use User\Handler\Role\UpdateRoleHandler;

/**
 * Class UpdateRoleHandlerFactory
 * @package User\Handler\Role\Factory
 */
class UpdateRoleHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return UpdateRoleHandler
     */
    public function __invoke( ContainerInterface $container ) : UpdateRoleHandler
    {
        $roleManager   = $container->get( RoleManager::class );
        $entityManager = $container->get('doctrine.entity_manager.orm_default');

        return new UpdateRoleHandler( $roleManager, new FormErrorFilter(), $entityManager );
    }
}
