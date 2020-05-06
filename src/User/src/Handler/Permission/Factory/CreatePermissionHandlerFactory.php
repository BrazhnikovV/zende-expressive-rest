<?php

declare(strict_types=1);

namespace User\Handler\Permission\Factory;

use Psr\Container\ContainerInterface;
use User\Handler\Permission\CreatePermissionHandler;

/**
 * Class CreatePermissionHandlerFactory
 * @package User\Handler\Permission\Factory
 */
class CreatePermissionHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return CreatePermissionHandler
     */
    public function __invoke(ContainerInterface $container) : CreatePermissionHandler
    {
        return new CreatePermissionHandler();
    }
}
