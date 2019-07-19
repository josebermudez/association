<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliates', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->string('last_name');
			$table->string('address');
			$table->string('email');
			$table->string('phone');
			$table->string('cell_phone');
			$table->string('birthday');
			$table->string('occupation');
			$table->string('marital_status');
			$table->string('number_of_children');
			$table->tinyInteger('accepted_terms_conditions');
			$table->tinyInteger('accept_contact_by_cell_phone');
			$table->tinyInteger('accept_contact_by_phone');
			$table->tinyInteger('accept_contact_by_email');
			$table->longText('notes');
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
        Schema::dropIfExists('affiliates');
    }
}
