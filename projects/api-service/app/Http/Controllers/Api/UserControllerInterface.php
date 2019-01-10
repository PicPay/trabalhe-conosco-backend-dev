<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

/**
 * Interface UserInterface
 * @package App\Http\Controllers\Api
 */
interface UserControllerInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request);
}
