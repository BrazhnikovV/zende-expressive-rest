<?php
namespace User\Filter;

use Zend\Filter\AbstractFilter;

/**
 * Class FormErrorFilter
 * @package User\Filter
 */
class FormErrorFilter extends AbstractFilter
{
    /**
     * filter -
     * @param string $value - массив ошибок
     * @return mixed
     */
    public function filter( $value )
    {
        $errors    = [];
        $errReturn = [];

        $messages = $value;
        foreach ( $messages as $key => $message ) {
            $errors['field'] = $key;
            $errors['message'] = $message[ key( $message ) ];
            $errReturn[] = $errors;
        }
        return $errReturn;
    }
}
