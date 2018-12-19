<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Item extends Model
{

    public $fillable = ['name','username'];
    public $incrementing = false;

}
