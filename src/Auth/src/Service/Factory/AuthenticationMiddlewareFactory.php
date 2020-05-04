<?php

namespace Auth\Service\Factory;

use Auth\Service\AuthAdapter;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Mezzio\Authentication\AuthenticationMiddleware;

class AuthenticationMiddlewareFactory implements FactoryInterface
{
    /**
     * This method creates the AuthAdapter service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authAdapter = $container->get(AuthAdapter::class);
        return new AuthenticationMiddleware($authAdapter);
    }
}
