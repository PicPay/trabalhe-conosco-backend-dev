<?php

namespace App\Console\Commands;
use App\Post;

use Exception;
use Illuminate\Console\Command;
use Elasticsearch\ClientBuilder;


class importDBCommand extends Command{
    protected $signature = "import:DB";

    protected $description = "";
    
    public function handle(){
        echo "test";
    }

}