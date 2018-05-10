<?php

namespace App\Repository;

use App\Entity\User;

class UserRepository extends AbstractEntityManagerRepository
{
    protected function getEntityName(): string
    {
        return User::class;
    }

    public function search(string $q, int $page = 1)
    {
        $dql = <<<'DQL'
SELECT u
FROM App\Entity\User u
WHERE MATCH (u.name,u.username) AGAINST(:search BOOLEAN) > 0
ORDER BY u.priority
DQL;

        $query = $this->entityManager->createQuery($dql);
        $query->setParameter(':search', $q);
        $query->setMaxResults(15);
        $query->setFirstResult(($page-1)*15);
        return $query->getResult();
    }

    public function countSearch(string $q): int
    {

        $dql = <<<'DQL'
SELECT COUNT(u)
FROM App\Entity\User u
WHERE MATCH (u.name,u.username) AGAINST(:search BOOLEAN) > 0
DQL;

        $query = $this->entityManager->createQuery($dql);
        $query->setParameter(':search', $q);

        return $query->getSingleScalarResult();
    }

    public function updateUsersPriority(array $ids, int $priority)
    {
        $dql = $this->entityManager->createQueryBuilder();
        $dql->update(User::class, 'u')
            ->set('u.priority', ':priority')
            ->where('u.id IN(:ids)');

        $dql->setParameter('priority', $priority)
            ->setParameter('ids', $ids);

        $dql->getQuery()->execute();
    }

}