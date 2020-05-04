<?php
namespace User\Service;

use Zend\Authentication\Result;

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
     * @var User\Service\RbacManager $rbacManager - RBAC manager.
     */
    private $rbacManager;

    /**
     * AuthManager constructor.
     * @param $authService
     * @param $sessionManager
     * @param $config
     * @param $rbacManager
     */
    public function __construct($rbacManager)
    {
        $this->rbacManager = $rbacManager;
    }

    /**
     * Performs a login attempt. If $rememberMe argument is true, it forces the session
     * to last for one month (otherwise the session expires on one hour).
     * @param $email
     * @param $password
     * @param $rememberMe
     * @return Result
     * @throws \Exception
     */
    public function login($email, $password, $rememberMe)
    {
        // Authenticate with login/password.

        return [];
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
