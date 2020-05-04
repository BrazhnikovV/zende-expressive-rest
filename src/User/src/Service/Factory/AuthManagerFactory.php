<?php
namespace User\Service\Factory;

use User\Service\AuthManager;
use Zend\Session\SessionManager;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class AuthManagerFactory - This is the factory class for AuthManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 * @package User\Service\Factory
 */
class AuthManagerFactory implements FactoryInterface
{
    /**
     * This method creates the AuthManager service and returns its instance.
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return object|AuthManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entity_manager.orm_default');
        // Instantiate the AuthManager service and inject dependencies to its constructor.
        return new AuthManager($entityManager);
    }
}
