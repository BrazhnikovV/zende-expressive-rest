<?php

declare(strict_types=1);

namespace Auth\Handler\Login;

use Auth\Form\LoginForm;
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
     * @access private
     * @var Auth\Service\JwtService $jwtService - JWT service.
     */
    private $jwtService;

    /**
     * Constructor.
     * @param $entityManager
     * @param $authManager
     * @param $userManager
     * @param $jwtService
     */
    public function __construct( $entityManager, $authManager, $userManager, $jwtService )
    {
        $this->entityManager = $entityManager;
        $this->authManager   = $authManager;
        $this->userManager   = $userManager;
        $this->jwtService    = $jwtService;
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
        $this->userManager->createAdminUserIfNotExists();

        // Create login form
        $form = new LoginForm();
        $data = json_decode($request->getBody()->getContents(), true);
        // Fill in the form with POST data

        $form->setData($data);

        // Validate form
        if( $form->isValid() ) {
            $user = $this->authManager->login($data);

            if ( $user ) {
                $token = $this->jwtService->generateJwt( $user );

                return new JsonResponse([
                    'form'  => $data,
                    'data' => $token
                ]);
            } else
                return new JsonResponse(['errors' => ['Неверное имя пользователя или пароль']]);
        } else {
            return new JsonResponse(['errors' => $form->getMessages()]);
        }
    }
}
