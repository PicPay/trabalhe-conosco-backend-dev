<?php

namespace App\Services;
use App\User;
use Illuminate\Support\Facades\DB;

class UserService
{
  public function getUsersPaginated($keyword=null, $page = 1)
  {
    $query = User::query();

    if($keyword) {
      $query-> whereRaw("match(name, userName) against('+*$keyword*' in boolean mode)");
    }

    return $query->orderBy('priority', 'desc')
      ->paginate(15);
  }

  public function prioritizeUsers()
  {

    $priority_1_users_list_txt = file_get_contents('https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_1.txt');
    $priority_1_users_list = explode(PHP_EOL, $priority_1_users_list_txt);

    $priority_2_users_list_txt = file_get_contents('https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_2.txt');
    $priority_2_users_list = explode(PHP_EOL, $priority_2_users_list_txt);

    collect($priority_1_users_list)->map(function ($id){
      DB::table('users')
        ->where('id', $id)
        ->update(['priority' => 1]);
    });

    collect($priority_2_users_list)->map(function ($id){
      DB::table('users')
        ->where('id', $id)
        ->update(['priority' => 2]);
    });
  }

}

