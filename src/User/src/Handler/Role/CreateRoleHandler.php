<?php

declare(strict_types=1);

namespace User\Handler\Role;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class CreateRoleHandler
 * @package User\Handler\Role
 */
class CreateRoleHandler implements RequestHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle( ServerRequestInterface $request ) : ResponseInterface
    {
        return new JsonResponse([[
            'handler' => 'Create role'
        ]]);
    }
}
