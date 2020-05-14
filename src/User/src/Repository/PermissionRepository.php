<?php
namespace User\Repository;

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
            ->orderBy('p.id', 'DESC');

        return $queryBuilder->getQuery()->getArrayResult();
    }

    /**
     * findPermissionById - Retrieves one permission
     * @param $id
     * @return array
     */
    public function findPermissionById( $id )
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('p')
            ->from(\User\Entity\Permission::class, 'p')
            ->where("p.id = ?1")
            ->setParameter("1", $id)
            ->getMaxResults(1);

        return $queryBuilder->getQuery()->getArrayResult();
    }
}
