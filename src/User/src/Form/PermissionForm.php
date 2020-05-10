<?php

namespace User\Form;

use User\Validator\PermissionExistsValidator;
use Zend\Form\Form;

class PermissionForm extends Form
{
    /**
     * @access private
     * @var string $scenario - сценарий заполнения формы
     */
    private $scenario;

    /**
     * @access private
     * @var Doctrine\ORM\EntityManager $entityManager - Doctrine entity manager.
     */
    private $entityManager;

    /**
     * @access private
     * @var User\Entity\Permission $permission - Permission entity.
     */
    private $permission;

    /**
     * RoleForm constructor.
     * @param string $scenario
     * @param null $entityManager
     * @param null $permission
     */
    public function __construct( $scenario='create', $entityManager = null, $permission = null )
    {
        $this->scenario      = $scenario;
        $this->entityManager = $entityManager;
        $this->permission    = $permission;

        // Define form name
        parent::__construct('permission-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        $this->addInputFilter();
    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {
        // Create input filter
        $inputFilter = $this->getInputFilter();

        // Add input for "name" field
        $inputFilter->add([
            'name'     => 'name',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 128
                    ],
                ],
                [
                    'name' => PermissionExistsValidator::class,
                    'options' => [
                        'entityManager' => $this->entityManager,
                        'permission' => $this->permission
                    ],
                ],
            ],
        ]);

        // Add input for "description" field
        $inputFilter->add([
            'name'     => 'description',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 0,
                        'max' => 1024
                    ],
                ],
            ],
        ]);

        // Add input for "inherit_roles" field
        $inputFilter->add([
            'name'       => 'inherit_roles',
            'required'   => false,
            'filters'    => [],
            'validators' => [],
        ]);
    }
}
