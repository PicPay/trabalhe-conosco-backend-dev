<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
{
    /**
     * @function: getCustomer($request)
     * $request: laravel request that contains post
     *
     * Object format:
       {
           "id" : "065d8403-8a8f-484d-b602-9138ff7dedcf",
           "name" : "Kylton Saura",
           "username" : "raimundiram" :
        }
     *
     * The function will do a search locating all possibilities of customer, even if the id, name and username are not matching, it will a search in all three and return all similar values
     * always using the SCORE system which returns according to the relevance of the DB
     *
     *
     * ATTENTION: For calling this API methos is also necessary 2 headers:
     *  Authorization : Bearer . $api_token
     *  Accept : application/json
     *
     * the $api_token is provided when creating a user by: http://127.0.0.1/api/auth/signup
     *
     **/
    function getCustomer(Request $request){
        $post_ison = $request->getContent();
        $post_obj = json_decode($post_ison);
        print_r($post_obj);


        $query_raw = DB::select(DB::raw("select * from customer as c left join customer_score as cs ON cs.customer_id = c.id where `c`.token LIKE '%". $post_obj->id ."%' OR `c`.name LIKE '%".$post_obj->name ."%' OR `c`.username LIKE '%". $post_obj->username ."%' order by cs.score, c.name ASC"));
        print_r($query_raw);

//        $query = DB::table('customer')
//            ->select("*")
//            ->join('customer_score', "customer_score.customer_id", "=", "customer.id")
//            ->where("customer.token" , "like" , "%". $post_obj->id ."%")
//            ->orWhere("customer.name" , "like" , "%". $post_obj->name ."%")
//            ->orWhere("customer.username" , "like" , "%". $post_obj->username ."%")
//            ->orderBy('customer_score.score', 'desc')
//            ->orderBy('customer.name', 'asc')
//            ->get();
//
//
//        print_r($query->toArray());





    }
}
