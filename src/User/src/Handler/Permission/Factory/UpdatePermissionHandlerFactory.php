<?php

declare(strict_types=1);

namespace User\Handler\Permission\Factory;

use Psr\Container\ContainerInterface;
use User\Handler\Permission\UpdatePermissionHandler;

/**
 * Class UpdatePermissionHandlerFactory
 * @package User\Handler\Permission\Factory
 */
class UpdatePermissionHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return UpdatePermissionHandler
     */
    public function __invoke( ContainerInterface $container ) : UpdatePermissionHandler
    {
        return new UpdatePermissionHandler();
    }
}
