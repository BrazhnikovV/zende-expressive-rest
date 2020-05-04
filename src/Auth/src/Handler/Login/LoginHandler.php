<?php

declare(strict_types=1);

namespace Auth\Handler\Login;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class LoginHandler
 * @package Auth\Handler\Login
 */
class LoginHandler implements RequestHandlerInterface
{
    /**
     * @access private
     * @var Doctrine\ORM\EntityManager $entityManager - Entity manager.
     */
    private $entityManager;

    /**
     * @access private
     * @var User\Service\AuthManager $authManager - Auth manager.
     */
    private $authManager;

    /**
     * @access private
     * @var User\Service\UserManager $userManager - User manager.
     */
    private $userManager;

    /**
     * Constructor.
     * @param $entityManager
     * @param $authManager
     * @param $userManager
     */
    public function __construct( $entityManager, $authManager, $userManager )
    {
        $this->entityManager = $entityManager;
        $this->authManager   = $authManager;
        $this->userManager   = $userManager;
    }

    /**
     * handle
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle( ServerRequestInterface $request ) : ResponseInterface
    {
        // Check if we do not have users in database at all. If so, create
        // the 'Admin' user.
        //$this->userManager->createAdminUserIfNotExists();

        return new JsonResponse([
            'login' => 'action',
        ]);
    }
}
