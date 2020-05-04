<?php
namespace User\Service;

use User\Entity\User;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;

/**
 * Class AuthManager - The AuthManager service is responsible for user's login/logout and simple access
 * filtering. The access filtering feature checks whether the current visitor
 * is allowed to see the given page or not.
 * @package User\Service
 */
class AuthManager
{
    // Constants returned by the access filter.
    const ACCESS_GRANTED = 1; // Access to the page is granted.
    const AUTH_REQUIRED  = 2; // Authentication is required to see the page.
    const ACCESS_DENIED  = 3; // Access to the page is denied.

    /**
     * @access private
     * @var Doctrine\ORM\EntityManager $entityManager -
     */
    private $entityManager;

    /**
     * AuthManager constructor.
     * @param $entityManager
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Performs a login attempt. If $rememberMe argument is true, it forces the session
     * to last for one month (otherwise the session expires on one hour).
     * @param $data
     * @return array
     */
    public function login( $data )
    {
        $user = $this->entityManager->getRepository(User::class)->findOneByEmail($data['username']);
        // If the user with such email exists, we need to check if it is active or retired.
        // Do not allow retired users to log in.
        if ( $user == null ) {
            return false;
        }
        if ( $user->getStatus() == User::STATUS_RETIRED ) {
             return false;
        }

        $bcrypt = new Bcrypt();
        $passwordHash = $user->getPassword();

        if ( $bcrypt->verify( $data['password'], $passwordHash ) ) {
            return $user;
        }
    }

    /**
     * Performs user logout.
     * @throws \Exception
     */
    public function logout()
    {
        // Allow to log out only when user is logged in.
    }
}
