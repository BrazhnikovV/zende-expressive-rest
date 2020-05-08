<?php

declare(strict_types=1);

namespace User\Handler\Permission;

use User\Entity\Permission;
use User\Form\PermissionForm;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class UpdatePermissionHandler
 * @package User\Handler\Permission
 */
class UpdatePermissionHandler implements RequestHandlerInterface
{
    /**
     * @access private
     * @var User\Service\PermissionManager $permissionManager - менеджер привилегий
     */
    private $permissionManager;

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
     * @param $permissionManager - менеджер привилегий
     * @param $formErrorFilter - фильтр для преобразования массива ошибок формы
     * @param $entityManager - менеджер сущностей
     */
    public function __construct( $permissionManager, $formErrorFilter, $entityManager )
    {
        $this->permissionManager = $permissionManager;
        $this->formErrorFilter   = $formErrorFilter;
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
        $data = json_decode( $request->getBody()->getContents(), true );
        $form = new PermissionForm('update', $this->entityManager, $permission );

        // Fill in the form with POST data
        $form->setData( $data );

        if( $form->isValid() ) {

            $permission = $this->permissionManager->updatePermission( $permission, $data );

            return new JsonResponse([
                'name' => $permission->getName(),
                'description' => $permission->getDescription()
            ]);
        } else {
            $response = new JsonResponse(
                $this->formErrorFilter->filter( $form->getMessages() )
            );

            return $response->withStatus(422 );
        }
    }
}
