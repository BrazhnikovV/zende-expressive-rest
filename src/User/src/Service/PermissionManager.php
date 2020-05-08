<?php
namespace User\Service;

use User\Entity\Permission;

/**
 * This service is responsible for adding/editing permissions.
 */
class PermissionManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * RBAC manager.
     * @var User\Service\RbacManager
     */
    private $rbacManager;

    /**
     * PermissionManager constructor.
     * @param $entityManager
     * @param $rbacManager
     */
    public function __construct($entityManager, $rbacManager)
    {
        $this->entityManager = $entityManager;
        $this->rbacManager = $rbacManager;
    }

    /**
     * addPermission - Adds a new permission.
     * @param $data
     * @return Permission
     * @throws \Exception
     */
    public function addPermission( $data )
    {
        $existingPermission = $this->entityManager->getRepository( Permission::class )->findOneByName($data['name']);
        if ( $existingPermission != null ) {
            throw new \Exception('Permission with such name already exists');
        }

        $permission = new Permission();
        $permission->setName($data['name']);
        $permission->setDescription($data['description']);

        $this->entityManager->persist($permission);
        $this->entityManager->flush();

        // Reload RBAC container.
        $this->rbacManager->init(true);

        return $permission;
    }

    /**
     * updatePermission - Updates an existing permission.
     * @param $permission - сущность привилегии
     * @param $data - данные формы
     * @return mixed
     * @throws \Exception
     */
    public function updatePermission( $permission, $data )
    {
        $existingPermission = $this->entityManager->getRepository( Permission::class )->findOneByName( $data['name'] );
        if ( $existingPermission != null && $existingPermission != $permission ) {
            throw new \Exception('Another permission with such name already exists' );
        }

        $permission->setName($data['name']);
        $permission->setDescription($data['description']);

        $this->entityManager->flush();

        // Reload RBAC container.
        $this->rbacManager->init(true);

        return $permission;
    }

    /**
     * deletePermission - Deletes the given permission.
     * @param $permission
     * @return mixed
     */
    public function deletePermission( $permission )
    {
        $this->entityManager->remove( $permission );
        $this->entityManager->flush();

        // Reload RBAC container.
        $this->rbacManager->init( true );

        return $permission;
    }

    /**
     * This method creates the default set of permissions if no permissions exist at all.
     */
    public function createDefaultPermissionsIfNotExist()
    {
        $permission = $this->entityManager->getRepository( Permission::class )->findOneBy([]);
        if ( $permission != null )
            return; // Some permissions already exist; do nothing.

        $defaultPermissions = [
            'user.manage' => 'Manage users',
            'permission.manage' => 'Manage permissions',
            'role.manage' => 'Manage roles',
            'profile.any.view' => 'View anyone\'s profile',
            'profile.own.view' => 'View own profile',
            'api.ping' => 'View test answer',
        ];

        foreach ( $defaultPermissions as $name => $description ) {
            $permission = new Permission();
            $permission->setName( $name );
            $permission->setDescription( $description );

            $this->entityManager->persist( $permission );
        }

        $this->entityManager->flush();

        // Reload RBAC container.
        $this->rbacManager->init( true );
    }
}

