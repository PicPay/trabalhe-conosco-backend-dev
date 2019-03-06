<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

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
     * @param array $order
     * @param int $page
     * @param int $size
     *
     * @return array
     */
    public function findByFilter(array $filters, array $order = [], int $page = 0, int $size = 15): array
    {
        $queryBuilder = $this->createQueryBuilder('user');
        $queryBuilder = $this->buildFilter($queryBuilder, $filters);
        $queryBuilder->setFirstResult($page * $size);
        $queryBuilder->setMaxResults($size);
        foreach ($order as $field => $value) {
            $queryBuilder->addOrderBy($field, $value);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param array $filters
     *
     * @return int
     * @throws NonUniqueResultException
     */
    public function countByFilter(array $filters): int
    {
        $queryBuilder = $this->createQueryBuilder('user');
        $queryBuilder->select('COUNT(user.pk)');
        $queryBuilder = $this->buildFilter($queryBuilder, $filters);

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param array $filters
     *
     * @return QueryBuilder
     */
    public function buildFilter(QueryBuilder $queryBuilder, array $filters): QueryBuilder
    {
        if(!empty($filters['name'])) {
            $queryBuilder->andWhere('user.name LIKE :name')
                ->setParameter('name', '%'.$filters['name'].'%');
        }
        if(!empty($filters['username'])) {
            $queryBuilder->andWhere('user.username LIKE :username')
                ->setParameter('username', '%'.$filters['username'].'%');
        }

        return $queryBuilder;
    }
}
