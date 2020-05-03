<?php

declare(strict_types=1);

namespace App\Handler\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class AuthorizationHandler implements MiddlewareInterface
{
    private $rbac;

    public function __construct($rbac)
    {
        $this->rbac = $rbac;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request);
        // TODO: Implement process() method.
    }
}
