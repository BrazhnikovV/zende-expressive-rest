<?php

declare(strict_types=1);

namespace User\Handler\Role\Factory;

use Psr\Container\ContainerInterface;
use User\Handler\Role\CreateRoleHandler;

/**
 * Class CreateRoleHandlerFactory
 * @package User\Handler\Role\Factory
 */
class CreateRoleHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return CreateRoleHandler
     */
    public function __invoke( ContainerInterface $container ) : CreateRoleHandler
    {
        return new CreateRoleHandler();
    }
}
