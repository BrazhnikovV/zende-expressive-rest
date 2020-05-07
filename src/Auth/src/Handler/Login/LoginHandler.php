<?php

declare(strict_types=1);

namespace Auth\Handler\Login;

use Auth\Form\LoginForm;
use User\Filter\FormErrorFilter;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

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
     * @access private
     * @var User\Filter\FormErrorFilter $formErrorFilter - фильтр для преобразования массива ошибок формы
     */
    private $formErrorFilter;

    /**
     * LoginHandler constructor.
     * @param $entityManager - менеджер сущностей
     * @param $authManager - менеджер аутентификации
     * @param $userManager - менеджер пользователей
     * @param $jwtService - сервис для работы с токенами jwt
     * @param $formErrorFilter - фильтр для преобразования ошибок валидации
     */
    public function __construct( $entityManager, $authManager, $userManager, $jwtService, $formErrorFilter )
    {
        $this->entityManager   = $entityManager;
        $this->authManager     = $authManager;
        $this->userManager     = $userManager;
        $this->jwtService      = $jwtService;
        $this->formErrorFilter = $formErrorFilter;
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
        $data = json_decode( $request->getBody()->getContents(), true );

        // Fill in the form with POST data
        $form->setData( $data );

        // Validate form
        if( $form->isValid() ) {
            $user = $this->authManager->login($data);

            if ( $user ) {
                $accessToken  = $this->jwtService->generateJwt( $user );
                $refreshToken = $this->jwtService->generateJwt( $user );

                return new JsonResponse([
                    'lang'     => 'ru',
                    'username' => $user->getEmail(),
                    'access-token'      => $accessToken['token'],
                    'access-token-exp'  => $accessToken['token_expired'],
                    'refresh-token'     => $refreshToken['token'],
                    'refresh-token-exp' => $refreshToken['token_expired']
                ]);
            } else
                $response = new JsonResponse([[
                    'field'   => 'Ошибка',
                    'message' => 'Неверное имя пользователя или пароль'
                ]]);
                return $response->withStatus(422);
        } else {
            $response = new JsonResponse(
                $this->formErrorFilter->filter( $form->getMessages() )
            );
            return $response->withStatus(422 );
        }
    }
}
