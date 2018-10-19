<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SaveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a default user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        DB::table('users')->insert([
            'name' => 'Admin PicPay',
            'email' => 'admin@picpay.com',
            'password' => bcrypt('yapcip'),
            'api_token' => base64_encode('yapcip')
        ]);
    }
}
