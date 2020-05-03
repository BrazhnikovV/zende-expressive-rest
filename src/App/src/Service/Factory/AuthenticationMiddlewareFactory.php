<?php


namespace App\Service\Factory;


use App\Service\AuthAdapter;
use Interop\Container\ContainerInterface;
use Mezzio\Authentication\AuthenticationMiddleware;
use Mezzio\Authorization\AuthorizationMiddleware;
use Zend\ServiceManager\Factory\FactoryInterface;

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
