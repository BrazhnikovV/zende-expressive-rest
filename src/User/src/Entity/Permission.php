<?php
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a permission.
 * @ORM\Entity(repositoryClass="\User\Repository\PermissionRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="permission")
 */
class Permission
{
    /**
     * @access protected
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @access protected
     * @ORM\Column(name="name")
     */
    protected $name;

    /**
     * @access protected
     * @ORM\Column(name="description")
     */
    protected $description;

    /**
     * @access protected
     * @ORM\Column(name="date_created")
     */
    protected $dateCreated;

    /**
     * @access protected
     * @ORM\Column(name="date_updated")
     */
    protected $dateUpdated;

    /**
     * @ORM\ManyToMany(targetEntity="User\Entity\Role", mappedBy="permissions")
     * @ORM\JoinTable(name="role_permission",
     *      joinColumns={@ORM\JoinColumn(name="permission_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     *      )
     */
    private $roles;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * setDateUpdated - Устанавливает дату создания данной привилегии.
     * @ORM\PrePersist
     */
    public function setDateCreated()
    {
        $this->dateCreated = date('Y-m-d H:i:s');
    }

    /**
     * getDateUpdated - Возвращает дату обновления данной привилегии.
     * @return mixed
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * setDateUpdated - Устанавливает дату обновления данной привилегии.
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function setDateUpdated()
    {
        $this->dateUpdated = date('Y-m-d H:i:s');
    }

    public function getRoles()
    {
        return $this->roles;
    }
}



