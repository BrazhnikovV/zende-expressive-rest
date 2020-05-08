<?php

declare(strict_types=1);

namespace User\Handler\Permission;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class DeletePermissionHandler
 * @package User\Handler\Permission
 */
class DeletePermissionHandler implements RequestHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle( ServerRequestInterface $request ) : ResponseInterface
    {
        // Create and return a response
    }
}
