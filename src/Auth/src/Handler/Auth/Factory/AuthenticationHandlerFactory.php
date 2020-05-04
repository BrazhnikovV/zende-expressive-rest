<?php

declare(strict_types=1);

namespace Auth\Handler\Auth\Factory;

use Auth\Service\AuthAdapter;
use Psr\Container\ContainerInterface;
use Auth\Handler\Auth\AuthenticationHandler;

/**
 * Class AuthenticationHandlerFactory
 * @package Auth\Handler\Auth\Factory
 */
class AuthenticationHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return AuthenticationHandler
     */
    public function __invoke(ContainerInterface $container) : AuthenticationHandler
    {
        $authAdapter = $container->get( AuthAdapter::class );
        return new AuthenticationHandler( $authAdapter );
    }
}
