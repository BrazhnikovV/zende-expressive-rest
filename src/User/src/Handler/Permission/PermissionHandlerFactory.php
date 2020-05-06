<?php

declare(strict_types=1);

namespace User\Handler\Permission;

use Psr\Container\ContainerInterface;

class PermissionHandlerFactory
{
    public function __invoke(ContainerInterface $container) : PermissionHandler
    {
        return new PermissionHandler();
    }
}
