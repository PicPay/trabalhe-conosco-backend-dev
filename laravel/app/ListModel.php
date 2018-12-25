<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class ListModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
//    public $timestamps = false;

    function getMajorList(Request $request){

        $show_per_page = $request->show_per_page;
        $page = $request->page;
        $offset = $show_per_page * ($page-1);

        $query = "select * from main_list_score as f join secondary_list_score as s on f.token = s.token LIMIT " . $offset .", " . $show_per_page;
        $query_raw = DB::select(DB::raw($query));

        $query_count = $this->countCustomersMajor();
        $total_pages = ceil($query_count / $show_per_page);


        $response_arr = array(
            "show_per_page" => $show_per_page,
            "offset" => $offset,
            "current_page" => $page,
            "total_rows"=> $query_count,
            "total_pages" => $total_pages,
            "data" => $query_raw
        );

        return $response_arr;
    }


    function getFirstList(Request $request){

        $show_per_page = $request->show_per_page;
        $page = $request->page;
        $offset = $show_per_page * ($page-1);

        $query = "select * from main_list_score as f LIMIT " . $offset .", " . $show_per_page;
        $query_raw = DB::select(DB::raw($query));

        $query_count = $this->countCustomersFirst();
        $total_pages = ceil($query_count / $show_per_page);

        $response_arr = array(
            "show_per_page" => $show_per_page,
            "offset" => $offset,
            "current_page" => $page,
            "total_rows"=> $query_count,
            "total_pages" => $total_pages,
            "data" => $query_raw
        );

        return $response_arr;
    }



    function getSecondaryList(Request $request){

        $show_per_page = $request->show_per_page;
        $page = $request->page;
        $offset = $show_per_page * ($page-1);

        $query = "select * from secondary_list_score as s LIMIT " . $offset .", " . $show_per_page;
        $query_raw = DB::select(DB::raw($query));

        $query_count = $this->countCustomersSecondary();
        $total_pages = ceil($query_count / $show_per_page);


        $response_arr = array(
            "show_per_page" => $show_per_page,
            "offset" => $offset,
            "current_page" => $page,
            "total_rows"=> $query_count,
            "total_pages" => $total_pages,
            "data" => $query_raw
        );

        return $response_arr;
    }

    function countCustomersFirst(){
        return count(DB::select(DB::raw("select * from main_list_score")));
    }
    function countCustomersSecondary(){
        return count(DB::select(DB::raw("select * from secondary_list_score")));
    }
    function countCustomersMajor(){
        return count(DB::select(DB::raw("select * from main_list_score as f join secondary_list_score as s on f.token = s.token")));
    }

    function updateScoreByToken($customer_id, $score){
        $query = "select * from customer_score where customer_id = '" . $customer_id ."'";
        $query_raw = DB::select(DB::raw($query));

        if($query_raw){
            if($score == 2) {
                switch ($query_raw[0]->score) {
                    case 0:
                    case 2:
                        $value = 2;
                        break;
                    case 1:
                    case 3:
                        $value = 3;
                        break;
                }
            }else{
                switch ($query_raw[0]->score) {
                    case 0:
                    case 1:
                        $value = 1;
                        break;
                    case 2:
                    case 3:
                        $value = 3;
                        break;
                }
            }
            DB::table('customer_score')
                ->where('customer_id', $customer_id)
                ->update(['score' => $value]);
        }else{
            DB::table('customer_score')->insert(
                ['customer_id' => $customer_id, 'score' => $score]
            );
        }

    }


    function addFirstList(Request $request){
        $token = $request->token;
        $date = date('Y-m-d H:i:s', time());

        $parameter = array(
            "token" => $token,
            "created_at" => $date,
            "updated_at" => $date,
        );

        $query = DB::table('main_list_score')->insert($parameter);

        $response_arr = array(
            "data" => $query
        );

        return $response_arr;
    }


    function addSecondaryList(Request $request){
        $token = $request->token;
        $date = date('Y-m-d H:i:s', time());

        $parameter = array(
            "token" => $token,
            "created_at" => $date,
            "updated_at" => $date,
        );

        $query = DB::table('secondary_list_score')->insert($parameter);

        $response_arr = array(
            "data" => $query
        );

        return $response_arr;
    }


    function removeScore($customer_id){
        return DB::table('customer_score')->where('customer_id', '=', $customer_id)->delete();
    }

    function removeFirstList(Request $request){
        return DB::table('main_list_score')->where('token', '=', $request->token)->delete();
    }

    function removeSecondaryList(Request $request){
        return DB::table('secondary_list_score')->where('token', '=', $request->token)->delete();
    }

}
