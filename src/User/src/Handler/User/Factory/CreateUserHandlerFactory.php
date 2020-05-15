<?php

declare(strict_types=1);

namespace User\Handler\User\Factory;

use User\Service\UserManager;
use User\Filter\FormErrorFilter;
use Psr\Container\ContainerInterface;
use User\Handler\User\CreateUserHandler;

/**
 * Class CreateUserHandlerFactory
 * @package User\Handler\User
 */
class CreateUserHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return CreateUserHandler
     */
    public function __invoke( ContainerInterface $container ) : CreateUserHandler
    {
        $userManager   = $container->get( UserManager::class );
        $entityManager = $container->get('doctrine.entity_manager.orm_default');

        return new CreateUserHandler( $userManager, $entityManager, new FormErrorFilter() );
    }
}
