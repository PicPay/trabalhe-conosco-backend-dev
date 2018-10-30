<?php

namespace App\Service;

use App\Repository\UsersPicpayRepository;
//use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Dotenv\Exception\ValidationException;
use App\Filter\UsersPicpay\UsersPicpayFilter;

/**
 * Class UsersPicpayService
 * @package App\Service
 */
class UsersPicpayService
{
    /**
     * @var UsersPicpayRepository
     */
    protected $usersPicpayRepository;

    /**
     * UsersPicpayService constructor.
     * @param UsersPicpayRepository $usersPicpayRepository
     */
    public function __construct(UsersPicpayRepository $usersPicpayRepository)
    {
        $this->usersPicpayRepository = $usersPicpayRepository;
    }

    /**
     * @param $id
     * @param $relevance
     */
    public function update($id, $relevance)
    {
        $userPicpay = $this->usersPicpayRepository->find($id);
        $userPicpay->relevance = $relevance;
        $userPicpay->save();
    }
}
