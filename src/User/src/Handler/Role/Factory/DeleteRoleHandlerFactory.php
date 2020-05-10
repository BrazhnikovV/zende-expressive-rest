<?php

declare(strict_types=1);

namespace User\Handler\Role\Factory;

use Psr\Container\ContainerInterface;
use User\Filter\FormErrorFilter;
use User\Handler\Role\DeleteRoleHandler;
use User\Service\RoleManager;

/**
 * Class DeleteRoleHandlerFactory
 * @package User\Handler\Role\Factory
 */
class DeleteRoleHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return DeleteRoleHandler
     */
    public function __invoke( ContainerInterface $container ) : DeleteRoleHandler
    {
        $roleManager   = $container->get( RoleManager::class );
        $entityManager = $container->get('doctrine.entity_manager.orm_default');

        return new DeleteRoleHandler( $roleManager, $entityManager );
    }
}
