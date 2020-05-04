<?php

namespace Auth\Service;

use Mezzio\Authentication\UserInterface;

/**
 * Class AuthDefaultUser
 * @package Auth\Service
 */
final class AuthDefaultUser  implements UserInterface
{
    /**
     * @access private
     * @var string $identity -
     */
    private $identity;

    /**
     * @access private
     * @var string[] $roles -
     */
    private $roles;

    /**
     * @access private
     * @var array $details -
     */
    private $details;

    /**
     * AuthDefaultUser constructor.
     * @param string $identity
     * @param object|null $roles
     * @param array $details
     */
    public function __construct( string $identity, object $roles = null, array $details = [] )
    {
        $this->identity = $identity;
        $this->roles = $roles;
        $this->details = $details;
    }

    /**
     * @return string
     */
    public function getIdentity() : string
    {
        return $this->identity;
    }

    /**
     * @return iterable
     */
    public function getRoles() : iterable
    {
        return $this->roles;
    }

    /**
     * @return array
     */
    public function getDetails() : array
    {
        return $this->details;
    }

    /**
     * @param mixed $default Default value to return if no detail matching $name is discovered.
     * @return mixed
     */
    public function getDetail(string $name, $default = null)
    {
        return $this->details[$name] ?? $default;
    }
}
