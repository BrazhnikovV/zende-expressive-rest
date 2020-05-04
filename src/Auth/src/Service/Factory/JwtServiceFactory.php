<?php


namespace Auth\Service\Factory;


use Auth\Service\JwtService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class JwtServiceFactory implements FactoryInterface
{
    public function __invoke( ContainerInterface $container, $requestedName, array $options = null )
    {
        $config = $container->get('config')['jwt'];

        $service = new JwtService();
        $service->setJwtConfig($config);

        return $service;
    }
}
