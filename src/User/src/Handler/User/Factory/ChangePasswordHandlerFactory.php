<?php

declare(strict_types=1);

namespace User\Handler\User\Factory;

use User\Service\UserManager;
use User\Filter\FormErrorFilter;
use Psr\Container\ContainerInterface;
use User\Handler\User\ChangePasswordHandler;

/**
 * Class ChangePasswordHandlerFactory
 * @package User\Handler\User\Factory
 */
class ChangePasswordHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return ChangePasswordHandler
     */
    public function __invoke( ContainerInterface $container ) : ChangePasswordHandler
    {
        $userManager   = $container->get( UserManager::class );
        $entityManager = $container->get('doctrine.entity_manager.orm_default');

        return new ChangePasswordHandler( $userManager, $entityManager, new FormErrorFilter() );
    }
}
