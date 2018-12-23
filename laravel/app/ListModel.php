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

        $query = "select c.* from main_list_score as f join secondary_list_score as s on f.token = s.token join customer as c on c.token = f.token LIMIT " . $offset .", " . $show_per_page;
        $query_raw = DB::select(DB::raw($query));

        $query_count = sizeof($query_raw);
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

        $query = "select c.* from main_list_score as f right join customer as c on f.token = c.token LIMIT " . $offset .", " . $show_per_page;
        $query_raw = DB::select(DB::raw($query));

        $query_count = sizeof($query_raw);
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

        $query = "select c.* from secondary_list_score as s right join customer as c on s.token = c.token LIMIT " . $offset .", " . $show_per_page;
        $query_raw = DB::select(DB::raw($query));

        $query_count = sizeof($query_raw);
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



    function countCustomers(){
        return DB::select(DB::raw("select c.* from main_list_score as f, secondary_list_score as s, customer as c where f.token = s.token and c.token = f.token")->fetchColumn());

    }



}
