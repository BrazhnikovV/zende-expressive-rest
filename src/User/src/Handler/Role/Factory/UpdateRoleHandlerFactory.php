<?php

declare(strict_types=1);

namespace User\Handler\Role\Factory;

use Psr\Container\ContainerInterface;
use User\Handler\Role\UpdateRoleHandler;

/**
 * Class UpdateRoleHandlerFactory
 * @package User\Handler\Role\Factory
 */
class UpdateRoleHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return UpdateRoleHandler
     */
    public function __invoke(ContainerInterface $container) : UpdateRoleHandler
    {
        return new UpdateRoleHandler();
    }
}
