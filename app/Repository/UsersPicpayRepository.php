<?php

namespace App\Repository;

use Cache;
use Illuminate\Container\Container as App;

/**
 * Class UsersPicpayRepository
 * @package App\Repository
 */
class UsersPicpayRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return 'App\Models\UsersPicpay';
    }

    /**
     * @param $pageItems
     * @param int $currentPage
     * @return mixed
     */
    public function paginated($pageItems, $currentPage = 1)
    {
        $expiration = 60 * 24;
        $key = 'usersPicpay_' . $currentPage;

        return Cache::remember(
            $key,
            $expiration,
            function () use ($pageItems) {
                return $this->model->orderByRaw('-relevance desc')->paginate($pageItems);
            }
        );
    }

    /**
     * @param $name
     * @param $pageItems
     * @param int $currentPage
     * @return mixed
     */
    public function searchByName($name, $pageItems, $currentPage = 1)
    {
        $expiration = 60 * 24;
        $key = 'usersPicpay_' . $name . $currentPage;

        return Cache::remember(
            $key,
            $expiration,
            function () use ($pageItems, $name) {
                return $this->model->where('name', 'like', "%{$name}%")
                    ->orWhere('username', 'like', "%{$name}%")
                    ->orderByRaw('-relevance desc')
                    ->paginate($pageItems);
            }
        );
    }
}
