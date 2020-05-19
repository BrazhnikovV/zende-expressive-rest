<?php

declare(strict_types=1);

namespace User\Handler\User;

use User\Entity\User;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class GetUserByIdHandler
 * @package User\Handler\User
 */
class GetUserByIdHandler implements RequestHandlerInterface
{
    /**
     * @access private
     * @var Doctrine\ORM\EntityManager $entityManager - Doctrine entity manager.
     */
    private $entityManager;

    /**
     * CreateRoleByIdHandler constructor.
     * @param $entityManager
     */
    public function __construct( $entityManager )
    {
        $this->entityManager   = $entityManager;
    }

    public function handle( ServerRequestInterface $request ) : ResponseInterface
    {
        $id   = (int) $request->getAttribute("id" );
        $user = $this->entityManager->getRepository( User::class )->findUserById( $id );

        if ( $user != null ) {
            return new JsonResponse($user[0]);
        } else {
            $response = new JsonResponse(['success' => false, 'id' => $id]);
            return $response->withStatus(422 );
        }
    }
}
