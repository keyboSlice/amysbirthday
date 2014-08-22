<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDb extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('markers', function($t)
		{
			$t->increments('id');
			$t->float('lat');
			$t->float('long');
			$t->string('title');
			$t->string('text');
		});

		Schema::create('riddles', function($t)
		{
			$t->increments('id');
			$t->string('text');
			$t->string('clue');
			$t->string('answer');
			$t->integer('marker_id');
			$t->integer('ask_order');
			$t->string('code');
		});

		Schema::create('users', function($t)
		{
			$t->increments('id');
			$t->string('username');
			$t->string('password');
			$t->integer('riddle_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
