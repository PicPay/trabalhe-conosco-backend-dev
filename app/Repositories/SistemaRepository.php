<?php

namespace App\Repositories;

use App\UsersPicpay;

class SistemaRepository
{
    
    public function search($query,$page)
    {
        if ($page == 1)
            $page = 0;
        
        $result = UsersPicpay::complexSearch(array(
            'body' => array(
                    'from' => $page*15, 
                    'size' => 15,
                    'query' => array(
                        'multi_match' => array(
                            'query' => $query,
                            'fields' => array( 'name', 'login' )
                        )
                    ),
                    'sort' => array(
                        'relevancia' => "desc"
                    )
                )
            )
        );
        return array( "result" => $result->toArray(), "total" => $result->totalHits() );
    }

}
