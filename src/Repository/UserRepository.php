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

}