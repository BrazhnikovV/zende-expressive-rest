<?php

declare(strict_types=1);

namespace User\Handler\User\Factory;

use User\Service\UserManager;
use User\Filter\FormErrorFilter;
use Psr\Container\ContainerInterface;
use User\Handler\User\UpdateUserHandler;

/**
 * Class UpdateUserHandlerFactory
 * @package User\Handler\User\Factory
 */
class UpdateUserHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return UpdateUserHandler
     */
    public function __invoke( ContainerInterface $container ) : UpdateUserHandler
    {
        $userManager   = $container->get( UserManager::class );
        $entityManager = $container->get('doctrine.entity_manager.orm_default');

        return new UpdateUserHandler( $userManager, new FormErrorFilter(), $entityManager );
    }
}
