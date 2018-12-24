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





}
