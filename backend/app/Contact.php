<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Sleimanx2\Plastic\Searchable;
use Laravel\Scout\Searchable;

class Contact extends Model
{
    use Searchable;

    // eloquent
    public $table = 'contacts';
    public $timestamps = false;
    protected $fillable = ['id', 'token', 'nome', 'username'];

    // sleimanx2 plastic
    /*public $searchable = ['id', 'nome', 'username'];
    public function buildDocument()
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'username' => $this->username
        ];
    }*/
}
