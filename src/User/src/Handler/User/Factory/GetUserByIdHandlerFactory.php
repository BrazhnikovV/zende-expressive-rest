<?php

declare(strict_types=1);

namespace User\Handler\User\Factory;

use Psr\Container\ContainerInterface;
use User\Handler\User\GetUserByIdHandler;

/**
 * Class GetUserByIdHandlerFactory
 * @package User\Handler\User
 */
class GetUserByIdHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return GetUserByIdHandler
     */
    public function __invoke( ContainerInterface $container ) : GetUserByIdHandler
    {
        $entityManager = $container->get('doctrine.entity_manager.orm_default');
        return new GetUserByIdHandler( $entityManager );
    }
}
