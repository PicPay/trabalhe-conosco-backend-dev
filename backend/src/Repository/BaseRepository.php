<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * BaseRepository
 */
class BaseRepository extends EntityRepository
{
    protected function addOrderingQueryBuilder(QueryBuilder $qb, $params = [])
    {

        // Ex.:/api/products?sorting[price]=asc&sorting[name]=asc

        $aliases = $qb->getRootAliases();
        $fields = array_keys($this->getClassMetadata()->fieldMappings);

        if (isset($params['sorting'])) {
            foreach ($params['sorting'] as $sorting_index => $sorting_val) {
                if (in_array($sorting_index, $fields)) {
                    $direction = ($sorting_val === 'asc') ? 'asc' : 'desc';
                    $qb->addOrderBy($aliases[0] . '.' . $sorting_index, $direction);
                }
            }
        } else {
            $qb->orderBy($aliases[0] . '.id', 'DESC');
        }

        return $qb;
    }
}
