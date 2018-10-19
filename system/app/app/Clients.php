<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Clients extends Eloquent
{
    //
    protected $connection = 'mongodb';

    protected $collection = 'clients';

}
