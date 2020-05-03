<?php
namespace App\Service;

use Laminas\Permissions\Rbac\Rbac;
use Mezzio\Authorization\AuthorizationInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Adapter used for authenticating user. It takes login and password on input
 * and checks the database if there is a user with such login (email) and password.
 * If such user exists, the service returns its identity (email). The identity
 * is saved to session and can be retrieved later with Identity view helper provided
 * by ZF3.
 */
class AuthorizationAdapter implements AuthorizationInterface
{
    public function isGranted(string $role, ServerRequestInterface $request): bool
    {
        return true;
    }
}


