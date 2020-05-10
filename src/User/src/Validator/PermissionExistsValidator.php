<?php

namespace User\Validator;

use User\Entity\Permission;
use Zend\Validator\AbstractValidator;

/**
 * Class PermissionExistsValidator - This validator class is designed for checking if there is an existing permission
 * with such a name.
 * @package User\Validator
 */
class PermissionExistsValidator extends AbstractValidator
{
    /**
     * Available validator options.
     * @var array
     */
    protected $options = array(
        'entityManager' => null,
        'permission' => null
    );

    // Validation failure message IDs.
    const NOT_SCALAR  = 'notScalar';
    const PERMISSION_EXISTS = 'permissionExists';

    /**
     * Validation failure messages.
     * @var array
     */
    protected $messageTemplates = array(
        self::NOT_SCALAR  => "The email must be a scalar value",
        self::PERMISSION_EXISTS  => "Another permission with such name already exists"
    );

    /**
     * PermissionExistsValidator constructor.
     * @param null $options
     */
    public function __construct( $options = null )
    {
        // Set filter options (if provided).
        if(is_array($options)) {
            if(isset($options['entityManager']))
                $this->options['entityManager'] = $options['entityManager'];
            if(isset($options['permission']))
                $this->options['permission'] = $options['permission'];
        }

        // Call the parent class constructor
        parent::__construct($options);
    }

    /**
     * isValid - Check if user exists.
     * @param mixed $value
     * @return bool
     */
    public function isValid( $value )
    {
        if(!is_scalar($value)) {
            $this->error(self::NOT_SCALAR);
            return false;
        }

        // Get Doctrine entity manager.
        $entityManager = $this->options['entityManager'];

        $permission = $entityManager->getRepository(Permission::class)->findOneByName($value);

        if($this->options['permission']==null) {
            $isValid = ($permission==null);
        } else {
            if($this->options['permission']->getName()!=$value && $permission!=null)
                $isValid = false;
            else
                $isValid = true;
        }

        // If there were an error, set error message.
        if(!$isValid) {
            $this->error(self::PERMISSION_EXISTS);
        }

        // Return validation result.
        return $isValid;
    }
}
