<?php
namespace App\Http\Controllers\Api;

use App\Entity\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class User
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller implements UserControllerInterface
{
    /**
     * @var User
     */
    protected $model;

    /**
     * @var array
     */
    protected $relatioships = ['preference'];

    /**
     * UserController constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function index(Request $request)
    {
        //
        $limit = $request->all()['limit'] ?? 15;
        $result = $this->model->paginate($limit);

        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $word = $request->input('word');
        $limit = $request->all()['limit'] ?? 15;

        $result = $this->model
            ->leftJoin('preference', 'user_id', '=', 'users.id')
            ->where('users.name', 'like', "%{$word}%")
            ->orWhere('users.username', 'like', "%{$word}%")
            ->orderBy('preference.position', 'desc')
            ->paginate($limit);

        return response()->json($result);
    }
}
