<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('viewers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('webinar_id')->unsigned();
			$table->foreign('webinar_id')->references('id')->on('webinars');
			$table->string('email')->nullable();
			$table->string('start_time')->nullable();
			$table->string('end_time')->nullable();
			$table->string('time_spent')->nullable();
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
		Schema::drop('viewers');
	}

}
