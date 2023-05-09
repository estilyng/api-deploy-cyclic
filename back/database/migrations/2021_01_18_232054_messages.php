<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Messages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('call_id');
            $table->foreignId('from');
            $table->foreignId('to');
            $table->text('content');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            // $table->foreign('call_id')->references('id')->on('calls')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('from')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('to')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
