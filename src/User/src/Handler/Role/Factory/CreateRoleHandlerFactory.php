<?php

declare(strict_types=1);

namespace User\Handler\Role\Factory;

use User\Service\RoleManager;
use User\Filter\FormErrorFilter;
use Psr\Container\ContainerInterface;
use User\Handler\Role\CreateRoleHandler;

/**
 * Class CreateRoleHandlerFactory
 * @package User\Handler\Role\Factory
 */
class CreateRoleHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return CreateRoleHandler
     */
    public function __invoke( ContainerInterface $container ) : CreateRoleHandler
    {
        $roleManager     = $container->get( RoleManager::class );
        $entityManager   = $container->get('doctrine.entity_manager.orm_default');
        $formErrorFilter = $container->get( FormErrorFilter::class );

        return new CreateRoleHandler( $roleManager, $formErrorFilter, $entityManager );
    }
}
