<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    //
    public $table = 'suggestions';
    public $timestamps = false;
    protected $fillable = ['id','token','level'];
}
