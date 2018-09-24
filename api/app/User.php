<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $fillable = [
        'name', 'username', 'email', 'is_admin', 'active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}