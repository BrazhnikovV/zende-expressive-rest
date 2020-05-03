<?php
namespace App\Service;

use Laminas\Permissions\Rbac\Rbac;
use Mezzio\Authentication\DefaultUser;
use Psr\Http\Message\ResponseInterface;
use Mezzio\Authentication\UserInterface;
use Psr\Http\Message\ServerRequestInterface;
use Mezzio\Authentication\AuthenticationInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router\RouteResult;

/**
 * Adapter used for authenticating user. It takes login and password on input
 * and checks the database if there is a user with such login (email) and password.
 * If such user exists, the service returns its identity (email). The identity
 * is saved to session and can be retrieved later with Identity view helper provided
 * by ZF3.
 */
class AuthAdapter implements AuthenticationInterface
{

    public function authenticate(ServerRequestInterface $request): ?UserInterface
    {
        return new DefaultUser("guest", ["guest"]);
        //return null;
        // TODO: Implement authenticate() method.
    }

    public function unauthorizedResponse(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(['status' => 401]);
    }
}


