<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * Class Customer
 * @package App
 * This is a eloquent Model, is not really like framework CI on which the MODEL takes care of the DB so every DB function is on model, we could have used it, but we didnt. (shame on us)
 */
class Customer extends Model
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

    function getCustomers(Request $request){
        $id = $request->id;
        $name = $request->name;
        $username = $request->username;
        $show_per_page = $request->show_per_page;
        $page = $request->page;


        $offset = $show_per_page * ($page-1);

        $where_array = array(
            "c.token" => $id,
            "c.name" => $name,
            "c.username" => $username,
        );

        $where = $this->prepareWhere($where_array);

        $query = "select c.id, c.token, c.name, c.username, cs.score from customer as c left join customer_score as cs ON cs.customer_id = c.id ". $where ." order by cs.score, c.name ASC LIMIT " . $offset . ", " . $show_per_page;
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

    function countCustomers($id, $name, $username){
        return DB::select(DB::raw("select * from customer as c left join customer_score as cs ON cs.customer_id = c.id where `c`.token LIKE '%". $id ."%' OR `c`.name LIKE '%".$name ."%' OR `c`.username LIKE '%". $username ."%' order by cs.score, c.name ASC")->fetchColumn());

    }


    function prepareWhere($where_array =array()){
        $where_strings = array();
        foreach($where_array as $k => $v){
            if(!is_null($v) || !empty($v)){
                $tstring = "" . $k . " LIKE '%" . $v . "%'";
                array_push($where_strings, $tstring);
            }
        }

        switch(sizeof($where_strings)){
            case 0:
                print_r('hu3');
                return false;
                break;
            case 1:
                $where = 'where ' . $where_strings[0];
                break;
            case 2:
                $where = 'where ' . $where_strings[0] . " OR " . $where_strings[1];
                break;
            case 3:
                $where = 'where ' . $where_strings[0] . " OR " . $where_strings[1] . " OR " . $where_strings[2];
                break;

        }

        return $where;
    }

}
