<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token');
            $table->integer('eternal')->default(0);
            $table->dateTime('lives_time');
            $table->integer('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('public_tokens');
    }
}
