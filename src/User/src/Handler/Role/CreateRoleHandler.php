<?php

declare(strict_types=1);

namespace User\Handler\Role;

use User\Form\RoleForm;
use User\Filter\FormErrorFilter;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class CreateRoleHandler
 * @package User\Handler\Role
 */
class CreateRoleHandler implements RequestHandlerInterface
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
     * @param $roleManager
     * @param $formErrorFilter
     * @param $entityManager
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
        $form = new RoleForm('create', $this->entityManager );
        $data = json_decode( $request->getBody()->getContents(), true );

        // Fill in the form with POST data
        $form->setData( $data );

        if( $form->isValid() ) {
            $role = $this->roleManager->addRole( $data );

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
