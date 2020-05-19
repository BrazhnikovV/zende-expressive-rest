<?php

declare(strict_types=1);

namespace User\Handler\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use User\Entity\User;
use Zend\Diactoros\Response\JsonResponse;

class DeleteUserHandler implements RequestHandlerInterface
{
    /**
     * @access private
     * @var User\Service\UserManager $userManager - менеджер пользователей
     */
    private $userManager;

    /**
     * @access private
     * @var Doctrine\ORM\EntityManager $entityManager - Doctrine entity manager.
     */
    private $entityManager;

    /**
     * DeleteRoleHandler constructor.
     * @param $userManager - менеджер пользователей
     * @param $entityManager - менеджер сущностей
     */
    public function __construct( $userManager, $entityManager )
    {
        $this->userManager     = $userManager;
        $this->entityManager   = $entityManager;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id   = (int) $request->getAttribute("id" );
        $user = $this->entityManager->getRepository( User::class )->findOneById( $id );

        if ( $user != null ) {
            if ( $user->getFullName() !== 'Admin' ) {
                $this->userManager->deleteUser( $user );
                return new JsonResponse( ['success' => true, 'id' => $id] );
            }
        }

        $response = new JsonResponse(['success' => false, 'id' => $id]);
        return $response->withStatus(422 );
    }
}
