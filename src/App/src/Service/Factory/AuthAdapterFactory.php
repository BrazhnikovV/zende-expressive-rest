<?php
namespace App\Service\Factory;

use App\Service\AuthAdapter;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * This is the factory class for AuthAdapter service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class AuthAdapterFactory implements FactoryInterface
{
    /**
     * This method creates the AuthAdapter service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AuthAdapter();
    }
}
