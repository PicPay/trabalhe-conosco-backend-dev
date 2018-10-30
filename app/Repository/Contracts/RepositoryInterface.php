<?php

namespace App\Repository\Contracts;

interface RepositoryInterface
{
    /**
     *
     * @param  array $columns
     * @return mixed
     */
    public function all(array $columns = array('*'));

    /**
     *
     * @param  int   $perPage
     * @param  array $columns
     * @return mixed
     */
    public function paginate(int $perPage = 20, array $columns = array('*'));

    /**
     *
     * @param  array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     *
     * @param  array  $data
     * @param  mixed  $id
     * @param  string $attribute
     * @return mixed
     */
    public function update(array $data, $id, string $attribute = 'id');

    /**
     *
     * @param  $id
     * @return mixed
     */
    public function delete($id);

    /**
     *
     * @param  $id
     * @param  array $columns
     * @return mixed
     */
    public function find($id, array $columns = array('*'));

    /**
     *
     * @param  string $field
     * @param  $value
     * @param  array  $columns
     * @return mixed
     */
    public function findBy(string $field, $value, array $columns = array('*'));
}
