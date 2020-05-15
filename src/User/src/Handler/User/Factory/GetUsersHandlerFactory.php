<?php

declare(strict_types=1);

namespace User\Handler\User\Factory;

use Psr\Container\ContainerInterface;
use User\Handler\User\GetUsersHandler;

/**
 * Class GetUsersHandlerFactory
 * @package User\Handler\User\Factory
 */
class GetUsersHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return GetUsersHandler
     */
    public function __invoke( ContainerInterface $container ) : GetUsersHandler
    {
        $entityManager = $container->get('doctrine.entity_manager.orm_default');
        return new GetUsersHandler( $entityManager );
    }
}
