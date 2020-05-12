<?php

declare(strict_types=1);

namespace User\Handler\Permission;

use User\Entity\Permission;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class GetPermissionHandler
 * @package User\Handler\Permission
 */
class GetPermissionHandler implements RequestHandlerInterface
{
    /**
     * @access private
     * @var Doctrine\ORM\EntityManager $entityManager - менеджер сущностей
     */
    private $em;

    /**
     * AuthManager constructor.
     * @param $entityManager
     */
    public function __construct( $entityManager )
    {
        $this->em = $entityManager;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle( ServerRequestInterface $request ) : ResponseInterface
    {
        $permissions = $this->em->getRepository(Permission::class)->findAllPermissions();
        return new JsonResponse( $permissions );
    }
}
