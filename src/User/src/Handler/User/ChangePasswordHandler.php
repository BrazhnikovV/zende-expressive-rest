<?php

declare(strict_types=1);

namespace User\Handler\User;

use User\Entity\User;
use User\Form\ChangePasswordForm;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class ChangePasswordHandler
 * @package User\Handler\User
 */
class ChangePasswordHandler implements RequestHandlerInterface
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
        $id   = (int) $request->getAttribute("id" );
        $user = $this->entityManager->getRepository( User::class )->findOneById( $id );

        if ( $user == null ) {
            $response = new JsonResponse(['success' => false, 'id' => $id]);
            return $response->withStatus(404 );
        }

        $form = new ChangePasswordForm('create', $this->entityManager );
        $data = json_decode( $request->getBody()->getContents(), true );

        $form->setData( $data );

        if( $form->isValid() ) {
            if ( $this->userManager->validatePassword( $user, $data['oldPassword'] ) === true ) {
                if ( $this->userManager->changePassword( $user, $data ) ) {
                    return new JsonResponse(['success' => true]);
                } else {
                    return new JsonResponse(['success' => false]);
                }
            } else {
                return new JsonResponse([
                    'field' => 'oldPassword',
                    'message' => 'Password incorrect'
                ]);
            }
        } else {

            $response = new JsonResponse(
                $this->formErrorFilter->filter( $form->getMessages() )
            );

            return $response->withStatus(400 );
        }
    }
}
