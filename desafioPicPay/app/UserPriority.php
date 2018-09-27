<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPriority extends Model
{
    //
    protected $fillable = ["id", "priority"];
    protected $casts = [
        'id' => 'string',
        'priority' => 'integer'
    ];


    public function users()
    {
        return $this->hasOne(User::class, "id", 'id');
    }
}
