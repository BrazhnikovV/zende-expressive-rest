<?php

declare(strict_types=1);

namespace User\Handler\Role;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class GetRoleHandler
 * @package User\Handler\Role
 */
class GetRoleHandler implements RequestHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle( ServerRequestInterface $request ) : ResponseInterface
    {
        return new JsonResponse([[
            'handler' => 'Get role'
        ]]);
    }
}
