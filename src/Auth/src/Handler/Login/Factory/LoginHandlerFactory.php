<?php

declare(strict_types=1);

namespace Auth\Handler\Login\Factory;

use Auth\Handler\Login\LoginHandler;
use Psr\Container\ContainerInterface;

class LoginHandlerFactory
{
    public function __invoke(ContainerInterface $container) : LoginHandler
    {
        return new LoginHandler();
    }
}
