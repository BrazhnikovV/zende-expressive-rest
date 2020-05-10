<?php

declare(strict_types=1);

namespace User\Handler\Permission;

use User\Entity\Permission;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class DeletePermissionHandler
 * @package User\Handler\Permission
 */
class DeletePermissionHandler implements RequestHandlerInterface
{
    /**
     * @access private
     * @var User\Service\PermissionManager $permissionManager - менеджер привилегий
     */
    private $permissionManager;

    /**
     * @access private
     * @var Doctrine\ORM\EntityManager $entityManager - Doctrine entity manager.
     */
    private $entityManager;

    /**
     * DeleteRoleHandler constructor.
     * @param $permissionManager - менеджер привилегий
     * @param $entityManager - менеджер сущностей
     */
    public function __construct( $permissionManager, $entityManager )
    {
        $this->permissionManager = $permissionManager;
        $this->entityManager     = $entityManager;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle( ServerRequestInterface $request ) : ResponseInterface
    {
        $id = (int) $request->getAttribute("id" );
        $permission = $this->entityManager->getRepository( Permission::class )->findOneById( $id );

        if ( $permission != null ) {
            $this->permissionManager->deletePermission( $permission );
            return new JsonResponse(['success' => true, 'id' => $id]);
        } else {
            $response = new JsonResponse(['success' => false, 'id' => $id]);
            return $response->withStatus(422 );
        }
    }
}
