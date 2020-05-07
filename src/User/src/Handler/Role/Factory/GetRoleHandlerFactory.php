<?php

declare(strict_types=1);

namespace User\Handler\Role\Factory;

use Psr\Container\ContainerInterface;
use User\Handler\Role\GetRoleHandler;

/**
 * Class GetRoleHandlerFactory
 * @package User\Handler\Role
 */
class GetRoleHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return GetRoleHandler
     */
    public function __invoke( ContainerInterface $container ) : GetRoleHandler
    {
        $entityManager = $container->get('doctrine.entity_manager.orm_default');
        return new GetRoleHandler( $entityManager );
    }
}
