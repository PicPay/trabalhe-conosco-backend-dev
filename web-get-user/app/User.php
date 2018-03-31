<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $casts = [ 'id' => 'string' ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'user_name'
    ];

    public function getUsers() {
        set_time_limit(0);
        $users = array();
        $file_n = public_path() . '/users.csv';
        if (file_exists($file_n)) {
            $file = fopen($file_n, "r");
            while(($data = fgetcsv($file, 200, ",")) !== FALSE) {
                $user = new User();
                $user->id = $data[0];
                $user->name = $data[1];
                $user->user_name = $data[2];
                $users[] = $user;
            }

            fclose($file);
        }

        return $users;
    }

    public function getUser($keyWord) {
        set_time_limit(0);
        $users = array();
        $file_n = public_path() . '/users.csv';
        if (file_exists($file_n)) {
            $file = fopen($file_n, "r");
            while(($data = fgetcsv($file, 200, ",")) !== FALSE) {
                if((strpos($data[1], $keyWord) !== false) || (strpos($data[2], $keyWord) !== false)){
                    $user = new User();
                    $user->id = $data[0];
                    $user->name = $data[1];
                    $user->user_name = $data[2];
                    $users[] = $user;
                }
            }

            fclose($file);
        }

        return $users;
    }
}
