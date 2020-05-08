<?php

declare(strict_types=1);

namespace User\Handler\Role;

use User\Entity\Role;
use User\Form\RoleForm;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class UpdateRoleHandler
 * @package User\Handler\Role
 */
class UpdateRoleHandler implements RequestHandlerInterface
{
    /**
     * @access private
     * @var User\Service\RoleManager $roleManager - менеджер ролей
     */
    private $roleManager;

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
     * @param $roleManager - менеджер ролей
     * @param $formErrorFilter - фильтр для преобразования массива ошибок формы
     * @param $entityManager - менеджер сущностей
     */
    public function __construct( $roleManager, $formErrorFilter, $entityManager )
    {
        $this->roleManager     = $roleManager;
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
        $role = $this->entityManager->getRepository( Role::class )->findOneById( $id );

        if ( $role == null ) {
            $response = new JsonResponse(['success' => false, 'id' => $id]);
            return $response->withStatus(422 );
        }

        $data = json_decode( $request->getBody()->getContents(), true );
        $form = new RoleForm('update', $this->entityManager, $role );

        // Fill in the form with POST data
        $form->setData( $data );

        if( $form->isValid() ) {

            $role = $this->roleManager->updateRole( $role, $data );

            return new JsonResponse([
                'name' => $role->getName(),
                'description' => $role->getDescription(),
                'inherit_roles' => $role->getParentRoles()
            ]);
        } else {
            $response = new JsonResponse(
                $this->formErrorFilter->filter( $form->getMessages() )
            );

            return $response->withStatus(422 );
        }
    }
}
