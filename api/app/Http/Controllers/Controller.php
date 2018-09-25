<?php

namespace App\Http\Controllers;

use App\UserPicPay;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Union\UnionPaginator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function users(Request $request)
    {
        $page = request('page', 1);

        $relevancy_ids = array_merge (file(app_path() . '/lista_relevancia_1.txt', FILE_IGNORE_NEW_LINES), file(app_path() . '/lista_relevancia_2.txt', FILE_IGNORE_NEW_LINES));
        $relevancy = implode("','", $relevancy_ids);

        //dd($request->search);
        if ($request->search) {
            $users_with_relevancy = UserPicPay::whereIn('id', $relevancy_ids)
                ->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('username', 'like', '%' . $request->search . '%')
                ->orderByRaw(DB::raw("FIELD (id,'" . $relevancy . "')"))
                ->skip(($page - 1) * 15)
                ->take(15)
                ->get();
            $count_relevancy = count($users_with_relevancy);

            if($count_relevancy == 0){
                //dd($request->search);
                $users = UserPicPay::whereNotIn('id', $relevancy_ids)
                    ->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('username', 'like', '%' . $request->search . '%')
                    ->skip(($page - 1) * 15)
                    ->take(15 - $count_relevancy)
                    ->get();
                $users;

            }elseif($count_relevancy < 15){
                $users_part = UserPicPay::whereNotIn('id', $relevancy_ids)
                    ->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('username', 'like', '%' . $request->search . '%')
                    ->skip(($page - 1) * 15)
                    ->take(15 - $count_relevancy)
                    ->get();
                $users = $users_with_relevancy->merge($users_part);
            }else{
                $users = $users_with_relevancy;
            }
        }else{
            $users_with_relevancy = UserPicPay::whereIn('id', $relevancy_ids)
                ->orderByRaw(DB::raw("FIELD (id,'" . $relevancy . "')"))
                ->skip(($page - 1) * 15)
                ->take(15)
                ->get();
            $count_relevancy = count($users_with_relevancy);
            if($count_relevancy == 0){
                $users = UserPicPay::whereNotIn('id', $relevancy_ids)
                    ->skip(($page - 1) * 15)
                    ->take(15 - $count_relevancy)
                    ->get();
            }elseif($count_relevancy < 15){
                $users_part = UserPicPay::whereNotIn('id', $relevancy_ids)
                    ->skip(($page - 1) * 15)
                    ->take(15 - $count_relevancy)
                    ->get();
                $users = $users_with_relevancy->merge($users_part);
            }else{
                $users = $users_with_relevancy;
            }
        }

        $paginator = new LengthAwarePaginator($users, $this->countTotal($request->search), 15, $page);

        return response()->json(
            $paginator
        );
    }

    public function countTotal($search)
    {
        if ($search) {
            return UserPicPay::where('name', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%')
                ->count();
        }else{
            return UserPicPay::count();
        }
    }

    public function login(Request $request)
    {

    }

    public function register(Request $request)
    {

    }

    public function logout(Request $request)
    {

    }
}
