<?php

declare(strict_types=1);

namespace User\Handler\Permission;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class UpdatePermissionHandler
 * @package User\Handler\Permission
 */
class UpdatePermissionHandler implements RequestHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle( ServerRequestInterface $request ) : ResponseInterface
    {
        return new JsonResponse([[
            'handler' => 'Update permission'
        ]]);
    }
}
