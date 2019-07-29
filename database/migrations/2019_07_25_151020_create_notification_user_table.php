<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_affiliated', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('affiliated_id')->unsigned();
            $table->integer('notification_id')->unsigned();
            $table->string('message');
            $table->tinyInteger('status');
            $table->longText('notes');
            $table->timestamps();
            $table->foreign('affiliated_id')->references('id')->on('affiliates')
                  ->onDelete('cascade');
            $table->foreign('notification_id')->references('id')->on('notifications')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_affiliated');
    }
}
