<?php
namespace User\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class RoleRepository
 * @package User\Repository
 */
class RoleRepository extends EntityRepository
{
    /**
     * Retrieves all roles in descending dateCreated order.
     * @return array
     */
    public function findAllRoles()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $queryBuilder->select('r')
            ->from(\User\Entity\Role::class, 'r');
            //->orderBy('r.dateCreated', 'DESC');

        return $queryBuilder->getQuery()->getArrayResult();
    }

    /**
     * findRoleById - Retrieves one role
     * @param $id
     * @return array
     */
    public function findRoleById( $id )
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('r')
            ->from(\User\Entity\Role::class, 'r')
            ->where("r.id = ?1")
            ->setParameter("1", $id)
            ->getMaxResults(1);

        return $queryBuilder->getQuery()->getArrayResult();
    }
}
