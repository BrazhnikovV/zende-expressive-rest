<?php


namespace App\Service\Factory;


use App\Service\AuthorizationAdapter;
use Interop\Container\ContainerInterface;
use Mezzio\Authorization\AuthorizationMiddleware;
use Psr\Http\Message\ResponseInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthorizationMiddlewareFactory implements FactoryInterface
{
    /**
     * This method creates the AuthAdapter service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authorizationAdapter = $container->get(AuthorizationAdapter::class);
        return new AuthorizationMiddleware($authorizationAdapter, $container->get(ResponseInterface::class));
    }
}
