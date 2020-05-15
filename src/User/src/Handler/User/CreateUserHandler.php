<?php

declare(strict_types=1);

namespace User\Handler\User;

use User\Form\UserForm;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class CreateUserHandler
 * @package User\Handler\User
 */
class CreateUserHandler implements RequestHandlerInterface
{
    /**
     * @access private
     * @var User\Service\UserManager $userManager - менеджер пользователей
     */
    private $userManager;

    /**
     * @access private
     * @var User\Filter\FormErrorFilter $formErrorFilter - фильтр для преобразования массива ошибок формы
     */
    private $formErrorFilter;

    /**
     * @access private
     * @var Doctrine\ORM\EntityManager $entityManager - Doctrine entity manager.
     */
    private $entityManager;

    /**
     * CreateUserHandler constructor.
     * @param $userManager - сервис для работы с пользователями
     * @param $entityManager - менеджер сущностей
     * @param $formErrorFilter - фильтр для преобразования массива ошибок формы
     */
    public function __construct( $userManager, $entityManager, $formErrorFilter )
    {
        $this->userManager     = $userManager;
        $this->formErrorFilter = $formErrorFilter;
        $this->entityManager   = $entityManager;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle( ServerRequestInterface $request ) : ResponseInterface
    {
        $form = new UserForm('create', $this->entityManager );
        $data = json_decode( $request->getBody()->getContents(), true );

        // Fill in the form with POST data
        $form->setData( $data );

        if( $form->isValid() ) {
            $user = $this->userManager->addUser( $data );

            return new JsonResponse([
                'email' => $user->getEmail(),
                'full_name' => $user->getFullName()
            ]);

        } else {

            $response = new JsonResponse(
                $this->formErrorFilter->filter( $form->getMessages() )
            );

            return $response->withStatus(422 );
        }
    }
}
