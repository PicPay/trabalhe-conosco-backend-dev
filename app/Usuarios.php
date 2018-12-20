<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    public $timestamps = true;

    protected $fillable = ['id', 'name', 'username'];
}
?>