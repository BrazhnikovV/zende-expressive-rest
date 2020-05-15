<?php
namespace User\Repository;

use Doctrine\ORM\EntityRepository;
use User\Entity\User;

/**
 * This is the custom repository class for User entity.
 */
class UserRepository extends EntityRepository
{
    /**
     * Retrieves all users in descending dateCreated order.
     * @return Query
     */
//    public function findOneById($id)
//    {
//        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
//        $queryBuilder->select('u')
//            ->from(User::class, 'u');
//
//        return $queryBuilder->getQuery()->getArrayResult();
//    }

    /**
     * Retrieves all users in descending dateCreated order.
     * @return Query
     */
    public function findAllUsers()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('u.id, u.email, u.fullName')
            ->from(User::class, 'u')
            ->orderBy('u.dateCreated', 'DESC');

        return $queryBuilder->getQuery()->getArrayResult();
    }
}
