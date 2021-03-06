<?php
namespace User\Service;

use User\Entity\Role;
use User\Entity\Permission;

/**
 * Class RoleManager - This service is responsible for adding/editing roles.
 * @package User\Service
 */
class RoleManager
{
    /**
     * @access private
     * @var Doctrine\ORM\EntityManager $entityManager - Doctrine entity manager.
     */
    private $entityManager;

    /**
     * @access private
     * @var User\Service\RbacManager $rbacManager - RBAC manager.
     */
    private $rbacManager;

    /**
     * RoleManager constructor.
     * @param $entityManager - менеджер сущностей
     * @param $rbacManager - менеджер авторизации
     */
    public function __construct( $entityManager, $rbacManager )
    {
        $this->entityManager = $entityManager;
        $this->rbacManager   = $rbacManager;
    }

    /**
     * Adds a new role.
     * @param $data
     * @return Role
     * @throws \Exception
     */
    public function addRole( $data )
    {
        $existingRole = $this->entityManager->getRepository( Role::class )->findOneByName( $data['name'] );
        if ( $existingRole != null ) {
            throw new \Exception('Role with such name already exists');
        }

        $role = new Role;
        $role->setName( $data['name'] );
        $role->setDescription( $data['description'] );

        // add parent roles to inherit
        $role = $this->addParentRolesToInherit( $data, $role );

        $this->entityManager->persist( $role );

        // Apply changes to database.
        $this->entityManager->flush();

        // Reload RBAC container.
        $this->rbacManager->init(true);

        return $role;
    }

    /**
     * Updates an existing role.
     * @param $role - сущность роли
     * @param $data - данные формы
     * @return mixed
     * @throws \Exception
     */
    public function updateRole( $role, $data )
    {
        $existingRole = $this->entityManager->getRepository( Role::class )->findOneByName( $data['name'] );
        if ( $existingRole != null && $existingRole != $role ) {
            throw new \Exception('Another role with such name already exists');
        }

        $role->setName( $data['name'] );
        $role->setDescription( $data['description'] );

        // clear parent roles, so we don't populate a database twice
        $role->clearParentRoles();

        // add the new parent roles to inherit
        $role = $this->addParentRolesToInherit( $data, $role );

        $this->entityManager->flush();

        // Reload RBAC container.
        $this->rbacManager->init(true);

        return $role;
    }

    /**
     * Deletes the given role.
     * @param $role
     * @return mixed
     */
    public function deleteRole( $role )
    {
        $this->entityManager->remove($role);
        $this->entityManager->flush();

        // Reload RBAC container.
        $this->rbacManager->init(true);

        return $role;
    }

    /**
     * This method creates the default set of roles if no roles exist at all.
     * @throws \Exception
     */
    public function createDefaultRolesIfNotExist()
    {
        $role = $this->entityManager->getRepository( Role::class )->findOneBy([]);
        if ( $role != null )
            return; // Some roles already exist; do nothing.

        $defaultRoles = [
            'Administrator' => [
                'description' => 'A person who manages users, roles, etc.',
                'parent' => null,
                'permissions' => [
                    'user.manage',
                    'role.manage',
                    'permission.manage',
                    'profile.any.view',
                    'api.ping',
                ],
            ],
            'Сustomer' => [
                'description' => 'A person who can log in and bue and view offers.',
                'parent' => null,
                'permissions' => [
                    'profile.own.view',
                ],
            ],
            'Shop' => [
                'description' => 'A person who can log in and create shop and create, delete, update offers.',
                'parent' => null,
                'permissions' => [
                    'profile.own.view',
                ],
            ],
            'GroupShops' => [
                'description' => 'A person who can log in and create any shops and create, delete, update offers.',
                'parent' => null,
                'permissions' => [
                    'profile.own.view',
                ],
            ],
            'Guest' => [
                'description' => 'A person who can log in and view own profile.',
                'parent' => null,
                'permissions' => [
                    'profile.own.view',
                ],
            ],
        ];

        foreach ( $defaultRoles as $name => $info ) {

            // Create new role
            $role = new Role();
            $role->setName( $name );
            $role->setDescription( $info['description'] );

            // Assign parent role
            if ( $info['parent'] != null ) {
                $parentRole = $this->entityManager->getRepository( Role::class )->findOneByName( $info['parent'] );
                if ( $parentRole == null ) {
                    throw new \Exception('Parent role ' . $info['parent'] . ' doesn\'t exist');
                }

                $role->setParentRole( $parentRole );
            }

            $this->entityManager->persist( $role );

            // Assign permissions to role
            $permissions = $this->entityManager->getRepository( Permission::class )->findByName( $info['permissions'] );
            foreach ( $permissions as $permission ) {
                $role->getPermissions()->add( $permission );
            }
        }

        // Apply changes to database.
        $this->entityManager->flush();

        // Reload RBAC container.
        $this->rbacManager->init(true);
    }

    /**
     * Retrieves all permissions from the given role and its child roles.
     * @param $role
     * @return array
     */
    public function getEffectivePermissions( $role )
    {
        $effectivePermissions = [];

        foreach ( $role->getParentRoles() as $parentRole )
        {
            $parentPermissions = $this->getEffectivePermissions( $parentRole );
            foreach ( $parentPermissions as $name=>$inherited ) {
                $effectivePermissions[$name] = 'inherited';
            }
        }

        foreach ( $role->getPermissions() as $permission )
        {
            if ( !isset( $effectivePermissions[$permission->getName()] ) ) {
                $effectivePermissions[$permission->getName()] = 'own';
            }
        }

        return $effectivePermissions;
    }

    /**
     * Updates permissions of a role.
     * @param $role - сущность роли
     * @param $data - данные формы
     * @throws \Exception
     */
    public function updateRolePermissions( $role, $data )
    {
        // Remove old permissions.
        $role->getPermissions()->clear();

        // Assign new permissions to role
        foreach ( $data['permissions'] as $permission ) {

            $permission = $this->entityManager->getRepository( Permission::class )->findOneById( $permission['id'] );
            if ( $permission == null ) {
                throw new \Exception('Permission with such name doesn\'t exist');
            }

            $role->getPermissions()->add( $permission );
        }

        // Apply changes to database.
        $this->entityManager->flush();

        // Reload RBAC container.
        $this->rbacManager->init( true );
    }

    /**
     * addParentRolesToInherit
     * @param $data - данные формы
     * @param $role - сущность создаваемой роли
     * @return mixed
     * @throws \Exception
     */
    private function addParentRolesToInherit( $data, $role )
    {
        if ( array_key_exists( 'inherit_roles', $data ) ) {
            $inheritedRoles = $data['inherit_roles'];
            if ( !empty( $inheritedRoles ) ) {
                foreach ( $inheritedRoles as $roleId ) {
                    $parentRole = $this->entityManager->getRepository( Role::class )->findOneById( $roleId );

                    if ( $parentRole == null ) {
                        throw new \Exception('Role to inherit not found');
                    }

                    if ( !$role->getParentRoles()->contains( $parentRole ) ) {
                        $role->addParent( $parentRole );
                    }
                }
            }
        }

        return $role;
    }
}

