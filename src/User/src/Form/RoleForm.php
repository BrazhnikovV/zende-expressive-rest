<?php

namespace User\Form;

use Zend\Form\Form;
use User\Validator\RoleExistsValidator;

/**
 * Class RoleForm - The form for collecting information about Role.
 * @package User\Form
 */
class RoleForm extends Form
{
    /**
     * @access private
     * @var string $scenario -
     */
    private $scenario;

    /**
     * @access private
     * @var Doctrine\ORM\EntityManager $entityManager - Doctrine entity manager.
     */
    private $entityManager;

    /**
     * @access private
     * @var User\Entity\Role $role - Role entity.
     */
    private $role;

    /**
     * RoleForm constructor.
     * @param string $scenario
     * @param null $entityManager
     * @param null $role
     */
    public function __construct( $scenario='create', $entityManager = null, $role = null )
    {
        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->role = $role;

        // Define form name
        parent::__construct('role-form');

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
                    'name' => RoleExistsValidator::class,
                    'options' => [
                        'entityManager' => $this->entityManager,
                        'role' => $this->role
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
