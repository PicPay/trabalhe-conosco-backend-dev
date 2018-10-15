<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\UsersPicpayRepository;
use Illuminate\Http\JsonResponse;
use Cache;

/**
 * Class UsersPicPayController
 * @package App\Http\Controllers
 */
class UsersPicPayController extends Controller
{
    /**
     * @var UsersPicpayRepository
     */
    protected $usersPicpayRepository;

    /**
     * UsersPicPayController constructor.
     * @param UsersPicpayRepository $usersPicpayRepository
     */
    public function __construct(UsersPicpayRepository $usersPicpayRepository)
    {
        $this->usersPicpayRepository = $usersPicpayRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $currentPage = \Request::get('page');

        $usersPicpay = $this->usersPicpayRepository->paginated(15, $currentPage);

        return view('UsersPicpay.users', compact('usersPicpay'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $currentPage = $request->get('page');
        $name = $request->get('name');

        if (isset($name)) {
            $usersPicpay = $this->usersPicpayRepository->searchByName($name, 15, $currentPage);

            return view('UsersPicpay.users', compact('usersPicpay'));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function searchApi(Request $request)
    {
        $name = $request->get('name');
        $currentPage = $request->get('page');

        return $this->usersPicpayRepository->searchByName($name, 15, $currentPage);
    }
}
