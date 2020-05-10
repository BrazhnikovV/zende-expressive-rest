<?php

declare(strict_types=1);

namespace User\Handler\Role;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use User\Entity\Role;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class DeleteRoleHandler
 * @package User\Handler\Role
 */
class DeleteRoleHandler implements RequestHandlerInterface
{
    /**
     * @access private
     * @var User\Service\RoleManager $roleManager - менеджер ролей
     */
    private $roleManager;

    /**
     * @access private
     * @var Doctrine\ORM\EntityManager $entityManager - Doctrine entity manager.
     */
    private $entityManager;

    /**
     * DeleteRoleHandler constructor.
     * @param $roleManager
     * @param $entityManager
     */
    public function __construct( $roleManager, $entityManager )
    {
        $this->roleManager   = $roleManager;
        $this->entityManager = $entityManager;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle( ServerRequestInterface $request ) : ResponseInterface
    {
        $id   = (int) $request->getAttribute("id" );
        $role = $this->entityManager->getRepository( Role::class )->findOneById( $id );

        if ( $role != null ) {
            $this->roleManager->deleteRole( $role );
            return new JsonResponse(['success' => true, 'id' => $id]);
        } else {
            $response = new JsonResponse(['success' => false, 'id' => $id]);
            return $response->withStatus(422 );
        }
    }
}
