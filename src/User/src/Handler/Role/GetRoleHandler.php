<?php

declare(strict_types=1);

namespace User\Handler\Role;

use Psr\Http\Message\ResponseInterface;
use User\Entity\Role;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class GetRoleHandler
 * @package User\Handler\Role
 */
class GetRoleHandler implements RequestHandlerInterface
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
        // !Fixme необходимо учитывать наличие пагинации на клиенте !!!
        $roles = $this->em->getRepository(Role::class)->findAllRoles();
        return new JsonResponse(
            $roles
        );
    }
}
