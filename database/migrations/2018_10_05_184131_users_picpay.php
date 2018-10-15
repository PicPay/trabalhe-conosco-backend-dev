<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class UsersPicpay
 */
class UsersPicpay extends Migration
{
    public function up()
    {
        Schema::create('users_picpay', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('username');
            $table->integer('relevance')->nullable( true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_picpay');
    }
}
