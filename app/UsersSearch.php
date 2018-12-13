<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersSearch extends Model
{
    protected $table = "userssearch";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'id', 'nome', 'username',
    ];
}
