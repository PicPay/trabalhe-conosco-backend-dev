<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use Illuminate\Support\Facades\DB;
use Validator;


class CustomerController extends Controller
{


    /**
     * Failed validation disable redirect
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }


    /**
     * @function: getCustomer($request)
     * $request: laravel request that contains post
     *
     * Object format:
       {
           "id" : "065d8403-8a8f-484d-b602-9138ff7dedcf",
           "name" : "Kylton Saura",
           "username" : "raimundiram",
           "show_per_page" : "20",
           "page" : "3"
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
        if(!$post_obj){
            $response['success'] = false;
            $response['error_code'] = 400;
            $response['message'] = "Please verify your JSON post parameters";
            $response['errors'] = array("format" => array("The format of the post Body is not correct"));
            return json_encode($response);
        }


        $request = new Request();

        $where_array = array(
            "c.token" => null,
            "c.name" => null,
            "c.username" => null
        );

        $parameters = $post_obj->parameters;
        foreach($parameters as $k=>$v){
            switch($k){
                case "id":
                    $where_array['c.token'] = empty($v) ? null : $v;
                    break;
                case "name":
                    $where_array['c.name'] = empty($v) ? null : $v;
                    break;
                case "username":
                    $where_array['c.username'] = empty($v) ? null : $v;

                    break;
            }
        }

        $request->replace([
            'id' => $where_array['c.token'],
            'name' => $where_array['c.name'],
            'username' => $where_array['c.username'],
            'show_per_page' => $post_obj->show_per_page,
            'page' => $post_obj->page,
            ]);

        $validator = Validator::make($request->all(),[
            'id' => 'nullable|min:4',
            'name' => 'nullable|min:4',
            'username' => 'nullable|min:4',
            'show_per_page' => 'required|integer',
            'page' => 'required|integer',
        ]);


        if ($validator->fails()) {
            $response['success'] = false;
            $response['error_code'] = 422;
            $response['message'] = "Wrong input in one of the body parameters";
            $response['errors'] = $validator->getMessageBag()->messages();
            return json_encode($response);
        }





        $customer_model = new Customer;

//        $customer_model = $this->getCustomer($post_obj->id, $post_obj->name, $post_obj->username, $post_obj->show_per_page, $post_obj->page);
        $response = $customer_model->getCustomers($request);

//        print_r($response);

        if(!empty($response['data'])){
            $response['success'] = true;
            $response['error_code'] = 200;
            $response['message'] = "success";
            $response['errors'] = array();
            return json_encode($response);
        }else{
            $response['success'] = true;
            $response['error_code'] = 204;
            $response['message'] = "No customer found";
            $response['errors'] = array("search" => array("No customer found"));
            return json_encode($response);
        }


        /**
         * not working the query below, we tried hard but unfortunatelly didint work.
         */
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
