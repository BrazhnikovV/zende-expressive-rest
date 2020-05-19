<?php

declare(strict_types=1);

namespace User\Handler\User;

use User\Entity\User;
use User\Form\UserForm;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class UpdateUserHandler
 * @package User\Handler\User
 */
class UpdateUserHandler implements RequestHandlerInterface
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
     * CreateRoleHandler constructor.
     * @param $userManager - менеджер пользователей
     * @param $formErrorFilter - фильтр для преобразования массива ошибок формы
     * @param $entityManager - менеджер сущностей
     */
    public function __construct( $userManager, $formErrorFilter, $entityManager )
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

        if ( $user->getFullName() === 'Admin' ) {
            $response = new JsonResponse(['success' => false, 'message' => 'Нельзя редактировать админа']);
            return $response->withStatus(422 );
        }

        $data = json_decode( $request->getBody()->getContents(), true );
        $form = new UserForm('update', $this->entityManager, $user );

        // Fill in the form with POST data
        $form->setData( $data );

        if( $form->isValid() ) {

            $user = $this->userManager->updateUser( $user, $data );

            return new JsonResponse([
                'email' => $user->getEmail(),
                'fullName' => $user->getFullName()
            ]);
        } else {
            $response = new JsonResponse(
                $this->formErrorFilter->filter( $form->getMessages() )
            );

            return $response->withStatus(422 );
        }
    }
}
