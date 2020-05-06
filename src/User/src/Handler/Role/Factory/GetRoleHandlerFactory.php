<?php

declare(strict_types=1);

namespace User\Handler\Role\Factory;

use Psr\Container\ContainerInterface;
use User\Handler\Role\GetRoleHandler;

/**
 * Class GetRoleHandlerFactory
 * @package User\Handler\Role
 */
class GetRoleHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return GetRoleHandler
     */
    public function __invoke( ContainerInterface $container ) : GetRoleHandler
    {
        return new GetRoleHandler();
    }
}
