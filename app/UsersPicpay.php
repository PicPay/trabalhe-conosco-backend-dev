<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class UsersPicpay extends Model
{
    use Searchable;

    public $timestamps = false;

    protected $fillable = [
        'id', 'name', 'login',
    ];

    public function searchableAs()
    {
        return 'userspicpay_index';
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        unset($array['id']);

        return $array;
    }

    public function getScoutKey()
    {
        return $this->id;
    }

}
