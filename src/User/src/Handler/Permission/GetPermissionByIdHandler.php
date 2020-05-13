<?php

declare(strict_types=1);

namespace User\Handler\Permission;

use User\Entity\Permission;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class GetPermissionByIdHandler
 * @package User\Handler\Permission
 */
class GetPermissionByIdHandler implements RequestHandlerInterface
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
        $permission = $this->entityManager->getRepository( Permission::class )->findPermissionById($id);

        if ( $permission != null ) {
            return new JsonResponse($permission[0]);
        } else {
            $response = new JsonResponse(['success' => false, 'id' => $id]);
            return $response->withStatus(422 );
        }
    }
}
