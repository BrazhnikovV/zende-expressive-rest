<?php

declare(strict_types=1);

namespace Auth\Handler\Login\Factory;

use Auth\Service\JwtService;
use User\Service\AuthManager;
use User\Service\UserManager;
use Auth\Handler\Login\LoginHandler;
use Psr\Container\ContainerInterface;

/**
 * Class LoginHandlerFactory
 * @package Auth\Handler\Login\Factory
 */
class LoginHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return LoginHandler
     */
    public function __invoke( ContainerInterface $container ) : LoginHandler
    {
        $entityManager = $container->get( 'doctrine.entity_manager.orm_default' );
        $authManager   = $container->get( AuthManager::class );
        $userManager   = $container->get( UserManager::class );
        $jwtService    = $container->get( JwtService::class );

        return new LoginHandler( $entityManager, $authManager, $userManager, $jwtService );
    }
}
