<?php

declare(strict_types=1);

namespace User\Handler\Role;

use User\Entity\Role;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class GetRoleByIdHandler
 * @package User\Handler\Role
 */
class GetRoleByIdHandler implements RequestHandlerInterface
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

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle( ServerRequestInterface $request ) : ResponseInterface
    {
        $id   = (int) $request->getAttribute("id" );
        $role = $this->entityManager->getRepository( Role::class )->findRoleById($id);

        if ( $role != null ) {
            return new JsonResponse($role[0]);
        } else {
            $response = new JsonResponse(['success' => false, 'id' => $id]);
            return $response->withStatus(422 );
        }
    }
}
