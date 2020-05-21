<?php
namespace User\Form;

use Zend\Form\Form;
use Zend\InputFilter\ArrayInput;
use User\Validator\UserExistsValidator;

/**
 * Class UserForm - This form is used to collect user's email, full name, password and status. The form
 * can work in two scenarios - 'create' and 'update'. In 'create' scenario, user
 * enters password, in 'update' scenario he/she doesn't enter password.
 * @package User\Form
 */
class ChangePasswordForm extends Form
{
    /**
     * Scenario ('create' or 'update').
     * @var string 
     */
    private $scenario;

    /**
     * UserForm constructor.
     * @param string $scenario - сценарий заполнения формы
     */
    public function __construct( $scenario = 'create' )
    {
        // Define form name
        parent::__construct('change-password-form');
     
        // Set POST method for this form
        $this->setAttribute('method', 'post');
        
        // Save parameters for internal use.
        $this->scenario = $scenario;

        $this->addInputFilter();          
    }
    
    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter() 
    {
        // Create main input filter
        $inputFilter = $this->getInputFilter();        
                
        // Add input for "oldPassword" field
        $inputFilter->add([
            'name'     => 'oldPassword',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 64
                    ],
                ],
            ],
        ]);
        
        // Add input for "newPassword" field
        $inputFilter->add([
            'name'     => 'newPassword',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 64
                    ],
                ],
            ],
        ]);

        // Add input for "confirm_new_password" field
        $inputFilter->add([
            'name'     => 'confirmPassword',
            'required' => true,
            'filters'  => [
            ],
            'validators' => [
                [
                    'name'    => 'Identical',
                    'options' => [
                        'token' => 'newPassword',
                        'min' => 4,
                        'max' => 64
                    ],
                ],
            ],
        ]);
    }           
}
