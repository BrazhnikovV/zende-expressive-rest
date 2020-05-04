<?php
namespace Auth\Service;

use Mezzio\Authentication\DefaultUser;
use Psr\Http\Message\ResponseInterface;
use Mezzio\Authentication\UserInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Mezzio\Authentication\AuthenticationInterface;

/**
 * Class AuthAdapter - Adapter used for authenticating user. It takes login and password on input
 * and checks the database if there is a user with such login (email) and password.
 * If such user exists, the service returns its identity (email). The identity
 * is saved to session and can be retrieved later with Identity view helper provided
 * by ZF3.
 * @package App\Service
 */
class AuthAdapter implements AuthenticationInterface
{

    /**
     * authenticate
     * @param ServerRequestInterface $request
     * @return UserInterface|null
     */
    public function authenticate( ServerRequestInterface $request ): ?UserInterface
    {
        // !Fixme когда передается неизвестная роль - вылетает exeption - No role with name "guests" could be found
        return new DefaultUser("guest", ["guest"]);
    }

    /**
     * unauthorizedResponse
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function unauthorizedResponse( ServerRequestInterface $request ): ResponseInterface
    {
        return new JsonResponse( ['status' => 401] );
    }
}


