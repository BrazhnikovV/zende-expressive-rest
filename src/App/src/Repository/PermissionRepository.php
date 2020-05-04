<?php
namespace App\Repository;

use User\Entity\Permission;
use Doctrine\ORM\EntityRepository;

/**
 * This is the custom repository class for Permission entity.
 */
class PermissionRepository extends EntityRepository
{
    /**
     * Retrieves all permissions in descending dateCreated order.
     * @return Query
     */
    public function findAllPermissions()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Permission::class, 'p')
            ->orderBy('p.dateCreated', 'DESC');

        return $queryBuilder->getQuery();
    }
}
