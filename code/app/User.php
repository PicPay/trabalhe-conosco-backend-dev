<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model 
{
  protected $table = 'users';
  public $incrementing = false;
  public $timestamps = false;
}
