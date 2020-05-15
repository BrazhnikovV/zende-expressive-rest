<?php

declare(strict_types=1);

namespace User\Handler\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use User\Entity\User;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class GetUsersHandler
 * @package User\Handler\User
 */
class GetUsersHandler implements RequestHandlerInterface
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
        $roles = $this->em->getRepository( User::class )->findAllUsers();
        return new JsonResponse( $roles );
    }
}
