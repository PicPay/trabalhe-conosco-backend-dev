<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * Class UserRepository
 *
 * @package App\Repository
 */
class UserRepository extends EntityRepository
{
    /**
     * @param User $user
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     * @throws \InvalidArgumentException
     */
    public function save(User $user)
    {
        try {
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();
        }
        catch (UniqueConstraintViolationException $e) {
            throw new \InvalidArgumentException('User already exists.');
        }
    }

    /**
     * @param array $filters
     * @param int $page
     * @param int $size
     *
     * @return array
     */
    public function findByFilter(array $filters, int $page = 0, int $size = 15)
    {
        $queryBuilder = $this->createQueryBuilder('user');
        if(!empty($filters['name'])) {
            $queryBuilder->andWhere('user.name LIKE :name')
                ->setParameter('name', '%'.$filters['name'].'%');
        }
        if(!empty($filters['username'])) {
            $queryBuilder->andWhere('user.username LIKE :username')
                ->setParameter('username', '%'.$filters['username'].'%');
        }
        $queryBuilder->setFirstResult($page * $size);
        $queryBuilder->setMaxResults($size);
        $queryBuilder->orderBy('user.priority', 'ASC');
        $queryBuilder->addOrderBy('user.name', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }
}