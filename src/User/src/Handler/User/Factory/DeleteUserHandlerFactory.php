<?php

declare(strict_types=1);

namespace User\Handler\User\Factory;

use User\Service\UserManager;
use Psr\Container\ContainerInterface;
use User\Handler\User\DeleteUserHandler;

/**
 * Class DeleteUserHandlerFactory
 * @package User\Handler\User\Factory
 */
class DeleteUserHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return DeleteUserHandler
     */
    public function __invoke(ContainerInterface $container) : DeleteUserHandler
    {
        $userManager   = $container->get( UserManager::class );
        $entityManager = $container->get('doctrine.entity_manager.orm_default');

        return new DeleteUserHandler( $userManager, $entityManager );
    }
}
