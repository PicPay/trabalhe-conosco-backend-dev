<?php

namespace App\Repositories;

use Geotools;
use App\UsersPicpay;
use Cache;

class SistemaRepository
{
    
    public function search($param)
    {
            dd(UsersPicpay::where('name','LIKE','%'.$param.'%')->get()->chunk(15));
    }

}
