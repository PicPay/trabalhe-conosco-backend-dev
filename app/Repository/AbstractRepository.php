<?php

namespace App\Repository;

use App\Coverage\CoverageInterface;
use App\Filter\FilterInterface;
use App\Repository\Contracts\CoveragePolicyInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use App\Repository\Contracts\CriteriaInterface;
use App\Repository\Contracts\RepositoryInterface;

abstract class AbstractRepository implements RepositoryInterface, CriteriaInterface
{
    /**
     *
     * @var App
     */
    private $app;

    /**
     *
     * @var Model $model
     */
    protected $model;

    /**
     *
     * @var FilterInterface
     */
    protected $criteria;

    /**
     *
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     *
     * @var CoverageInterface
     */
    protected $coverage;

    /**
     *
     * @var bool
     */
    protected $skipCoverage = false;

    public function __construct(App $app, Collection $criteria, Collection $coverage)
    {
        $this->app = $app;
        $this->criteria = $criteria;
        $this->coverage = $coverage;
        $this->makeModel();
        $this->resetScope();
    }

    /**
     * Return repository model namespace
     *
     * @return string
     */
    abstract public function model();

    /**
     * Creating the model instance using IoC
     *
     * @throws \Exception
     */
    private function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        $this->model = $model;
    }

    /**
     * Query all records
     *
     * @param  array $columns
     * @return mixed
     */
    public function all(array $columns = array('*'))
    {
        $this->applyCriteria();
        return $this->model->get($columns);
    }

    /**
     * Query paged records
     *
     * @param  int   $perPage
     * @param  array $columns
     * @return mixed
     */
    public function paginate(int $perPage = 20, array $columns = array('*'))
    {
        $this->applyCriteria();
        $this->applyCoveragePolicy();

        return $this->model->paginate($perPage, $columns);
    }

    /**
     *
     * @param  array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     *
     * @param  array  $data
     * @param  mixed  $id
     * @param  string $attribute
     * @return bool
     */
    public function update(array $data, $id, string $attribute = 'id')
    {
        if ($this->model instanceof Model) {
            $data = $this->model->fill($data)->toArray();
        }
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     *
     * @param  array $data
     * @param  array $keys
     * @return bool
     */
    public function updateMultiple(array $data, array $keys)
    {
        $model = $this->model;
        foreach ($keys as $field => $attribute) {
            $model = $model->where($field, $attribute);
        }

        if ($this->model instanceof Model) {
            $data = $this->model->fill($data)->toArray();
        }

        return $model->update($data);
    }

    /**
     *
     * @param  $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     *
     * @param  $id
     * @param  array $columns
     * @return mixed
     */
    public function find($id, array $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    /**
     *
     * @param  string $field
     * @param  $value
     * @param  array  $columns
     * @return mixed
     */
    public function findBy(string $field, $value, array $columns = array('*'))
    {
        return $this->model->where($field, '=', $value)->first($columns);
    }

    /**
     * Reset filter scope to return skip criteria to default
     *
     * @return $this
     */
    public function resetScope()
    {
        $this->skipCriteria(false);
        return $this;
    }

    /**
     * Will disregard the filter in the next query
     *
     * @param  bool $status
     * @return $this
     */
    public function skipCriteria(bool $status = true)
    {
        $this->skipCriteria = $status;
        return $this;
    }

    /**
     * Get all filters
     *
     * @return FilterInterface
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * Query for a specific filter
     *
     * @param  FilterInterface $criteria
     * @return $this
     */
    public function getByCriteria(FilterInterface $criteria)
    {
        $this->model = $criteria->apply($this->model, $this);
        return $this;
    }

    /**
     *
     * @param  FilterInterface $criteria
     * @return $this
     */
    public function pushCriteria(FilterInterface $criteria)
    {
        $this->criteria->push($criteria);
        return $this;
    }

    /**
     *
     * @return $this
     */
    public function applyCriteria()
    {
        if ($this->skipCriteria === true) {
            return $this;
        }

        foreach ($this->getCriteria() as $criteria) {
            if ($criteria instanceof FilterInterface) {
                $this->model = $criteria->apply($this->model);
            }
        }

        return $this;
    }

    /**
     * Reset coverage scope to return skip coverage policy to default
     *
     * @return $this
     */
    public function resetScopeCoveragePolicy()
    {
        $this->skipCoveragePolicy(false);
        return $this;
    }

    /**
     * Will disregard the coverage policy in the next query
     *
     * @param  bool $status
     * @return $this
     */
    public function skipCoveragePolicy(bool $status = true)
    {
        $this->skipCoverage = $status;
        return $this;
    }

    /**
     * Get all coverage policy
     *
     * @return CoverageInterface
     */
    public function getCoveragePolicy()
    {
        return $this->coverage;
    }

    /**
     * Query for a specific coverage policy
     *
     * @param  CoverageInterface $coverage
     * @return $this
     */
    public function getByCoveragePolicy(CoverageInterface $coverage)
    {
        $this->model = $coverage->apply($this->model, $this);
        return $this;
    }

    /**
     *
     * @param  CoverageInterface $coverage
     * @return $this
     */
    public function pushCoveragePolicy(CoverageInterface $coverage)
    {
        $this->coverage->push($coverage);
        return $this;
    }

    /**
     *
     * @return $this
     */
    public function applyCoveragePolicy()
    {
        if ($this->skipCoverage === true) {
            return $this;
        }

        foreach ($this->getCoveragePolicy() as $coverage) {
            if ($coverage instanceof CoverageInterface) {
                $this->model = $coverage->apply($this->model);
            }
        }

        return $this;
    }
}
