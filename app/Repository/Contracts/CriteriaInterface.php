<?php

namespace App\Repository\Contracts;

use App\Filter\FilterInterface;

/**
 * Interface CriteriaInterface
 * @package App\Repository\Contracts
 */
interface CriteriaInterface
{

    /**
     * @return mixed
     */
    public function resetScope();


    /**
     * @param bool $status
     * @return mixed
     */
    public function skipCriteria(bool $status = true);


    /**
     * @return mixed
     */
    public function getCriteria();


    /**
     * @param FilterInterface $criteria
     * @return mixed
     */
    public function getByCriteria(FilterInterface $criteria);


    /**
     * @param FilterInterface $criteria
     * @return mixed
     */
    public function pushCriteria(FilterInterface $criteria);

    /**
     * @return mixed
     */
    public function applyCriteria();
}
