<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('actions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('webinar_id')->unsigned();
			$table->foreign('webinar_id')->references('id')->on('webinars');
			$table->string('name');
			$table->string('start_time');
			$table->string('end_time');
			$table->string('tag_name')->nullable();
			$table->string('tag_id');
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
		Schema::drop('actions');
	}

}
