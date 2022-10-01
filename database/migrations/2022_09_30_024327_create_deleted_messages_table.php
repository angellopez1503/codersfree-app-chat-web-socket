<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deleted_messages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('id')->on("users");
            $table->unsignedBigInteger("message_id");
            $table->foreign("message_id")->references('id')->on("messages");

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
        Schema::dropIfExists('deleted_messages');
    }
};
