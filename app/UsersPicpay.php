<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;

class UsersPicpay extends Model
{
    protected $primaryKey = "id_sis";
    public $timestamps = false;
    use ElasticquentTrait;

    protected $fillable = [
        'codigo', 'name', 'login', 'relevancia', 'id_sis'
    ];

 	protected $mappingProperties = array(
	    'codigo' => [
	      'type' => 'text',
	      "analyzer" => "standard",
	    ],
	    'name' => [
	      'type' => 'text',
	      "analyzer" => "standard",
	    ],
	    'login' => [
	      'type' => 'text',
	      "analyzer" => "standard",
	    ],
	    'relevancia' => [
	      'type' => 'integer',
	      "analyzer" => "standard",
	    ],
	    'id_sis' => [
	      'type' => 'long',
	      "analyzer" => "standard",
	    ]
	  );

}
