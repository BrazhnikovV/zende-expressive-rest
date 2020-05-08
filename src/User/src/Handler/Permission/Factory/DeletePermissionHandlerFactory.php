<?php

declare(strict_types=1);

namespace User\Handler\Permission\Factory;

use Psr\Container\ContainerInterface;
use User\Handler\Permission\DeletePermissionHandler;

/**
 * Class DeletePermissionHandlerFactory
 * @package User\Handler\Permission\Factory
 */
class DeletePermissionHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return DeletePermissionHandler
     */
    public function __invoke( ContainerInterface $container ) : DeletePermissionHandler
    {
        return new DeletePermissionHandler();
    }
}
