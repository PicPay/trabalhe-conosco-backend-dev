<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersPicpay
 * @package App\Models
 */
class UsersPicpay extends Model
{
    /**
     * @var string
     */
    protected $table = 'users_picpay';

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'string'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'username',
        'relevance'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
