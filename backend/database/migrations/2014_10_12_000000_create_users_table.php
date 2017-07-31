<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        \App\User::create([
            'name' => 'João Gabriel',
            'email' => 'gabriel@orangepixel.com.br',
            'password' => Hash::make('123456')
        ])->save();


        \App\User::create([
            'name' => 'Teste',
            'email' => 'teste@orangepixel.com.br',
            'password' => Hash::make('teste')
        ])->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
