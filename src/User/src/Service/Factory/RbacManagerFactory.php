<?php
namespace User\Service\Factory;

use User\Service\RbacManager;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;

/**
 * Class RbacManagerFactory - This is the factory class for RbacManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 * @package User\Service\Factory
 */
class RbacManagerFactory
{
    /**
     * This method creates the RbacManager service and returns its instance.
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return RbacManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entity_manager.orm_default');
        $cache         = $container->get('FilesystemCache');

        $assertionManagers = [];
        $config = $container->get('config');
        if (isset($config['rbac_manager']['assertions'])) {
            foreach ($config['rbac_manager']['assertions'] as $serviceName) {
                $assertionManagers[$serviceName] = $container->get($serviceName);
            }
        }

        return new RbacManager($entityManager, $cache, $assertionManagers);
    }
}

