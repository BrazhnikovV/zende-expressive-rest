<?php

declare(strict_types=1);

namespace Auth\Handler\Auth;

use Psr\Http\Message\ResponseInterface;
use Mezzio\Authentication\UserInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AuthenticationHandler
 * @package Auth\Handler\Auth
 */
class AuthenticationHandler  implements MiddlewareInterface
{
    /**
     * @access private
     * @var Auth\Service\AuthAdapter $auth - AUTH Adapter.
     */
    private $auth;

    /**
     * AuthenticationHandler constructor.
     * @param $authAdapter
     */
    public function __construct( $authAdapter )
    {
        $this->auth = $authAdapter;
    }

    /**
     * process
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = $this->auth->authenticate($request);
        if (null !== $user) {
            return $handler->handle($request->withAttribute(UserInterface::class, $user)->withAttribute(\Zend\Expressive\Authentication\UserInterface::class, $user));
        }
        return $this->auth->unauthorizedResponse($request);
    }
}
