<?php

declare(strict_types=1);

namespace Auth\Handler\Rbac;

use Psr\Http\Message\ResponseInterface;
use Zend\Expressive\Router\RouteResult;
use Mezzio\Authentication\UserInterface;
use Psr\Http\Server\MiddlewareInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AuthorizationHandler
 * @package App\Handler\Auth
 */
class AuthorizationHandler implements MiddlewareInterface
{
    /**
     * @access private
     * @var User\Service\RbacManager $rbacManager - RBAC manager.
     */
    private $rbacManager;

    /**
     * AuthorizationHandler constructor.
     * @param $rbac
     */
    public function __construct( $rbac )
    {
        $this->rbacManager = $rbac;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface
    {
        $user = $request->getAttribute(UserInterface::class);
        if (false === $user) {
            return new EmptyResponse(401);
        }

        $route     = $request->getAttribute(RouteResult::class);
        $routeName = $route->getMatchedRoute()->getName();

        if ( !$this->rbacManager->isGranted($user, $routeName, null ) )
            return new EmptyResponse(403);

        return $handler->handle($request);
    }
}
