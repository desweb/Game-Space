<?php

use Illuminate\Database\Migrations\Migration;

class Init extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact', function($table)
		{
			$table->bigIncrements('id');
			$table->string('username');
			$table->string('email');
			$table->smallInteger('object', 1);
			$table->text('message');
			$table->smallInteger('state', 1);
			$table->timestamps();
		});

		Schema::create('image', function($table)
		{
			$table->bigIncrements('id');
			$table->string('url')			->unique();
			$table->string('server_path')	->unique();
			$table->smallInteger('type', 1);
			$table->timestamps();
		});

		Schema::create('map', function($table)
		{
			$table->bigIncrements('id');
			$table->string('title')->unique();
			$table->text('description');
			$table->text('datas');
			$table->timestamps();
		});

		/**
		 * Tables with foreign key
		 */

		Schema::create('game', function($table)
		{
			$table->bigIncrements('id');
			$table->string('reference', 32)	->unique();
			$table->string('title')			->unique();
			$table->text('description');
			$table->text('datas');
			$table->smallInteger('state', 1);
			$table->unsignedBigInteger('image_id');
			$table->foreign('image_id')->references('id')->on('image');
			$table->timestamps();
		});

		Schema::create('user', function($table)
		{
			$table->bigIncrements('id');
			$table->string('reference', 32)	->unique();
			$table->string('username', 50)	->unique();
			$table->string('email')			->unique();
			$table->string('password', 32);
			$table->date('birthday_at');
			$table->smallInteger('type', 1);
			$table->smallInteger('state', 1);
			$table->boolean('is_newsletter');
			$table->bigInteger('facebook_id');
			$table->unsignedBigInteger('photo_id');
			$table->foreign('photo_id')->references('id')->on('image');
			$table->timestamps();
		});

		Schema::create('user_token', function($table)
		{
			$table->bigIncrements('id');
			$table->string('token', 32)->unique();
			$table->smallInteger('type', 1);
			$table->datetime('expired_at');
			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('user');
			$table->timestamps();
		});

		Schema::create('game_user', function($table)
		{
			$table->bigIncrements('id');
			$table->string('reference', 32)->unique();
			$table->smallInteger('level');
			$table->integer('score');
			$table->unsignedBigInteger('game_id');
			$table->unsignedBigInteger('user_id');
			$table->foreign('game_id')->references('id')->on('game');
			$table->foreign('user_id')->references('id')->on('user');
			$table->timestamps();
		});

		Schema::create('achievement', function($table)
		{
			$table->bigIncrements('id');
			$table->string('reference', 32)->unique();
			$table->string('title');
			$table->text('description');
			$table->integer('score');
			$table->smallInteger('state', 1);
			$table->boolean('is_unlock');
			$table->unsignedBigInteger('image_id');
			$table->foreign('image_id')->references('id')->on('image');
			$table->timestamps();
		});

		Schema::create('user_achievement', function($table)
		{
			$table->bigIncrements('id');
			$table->string('reference', 32)->unique();
			$table->integer('score');
			$table->boolean('is_unlock');
			$table->unsignedBigInteger('achievement_id');
			$table->unsignedBigInteger('user_id');
			$table->foreign('achievement_id')	->references('id')->on('achievement');
			$table->foreign('user_id')			->references('id')->on('user');
			$table->timestamps();
		});

		Schema::create('game_witness', function($table)
		{
			$table->bigIncrements('id');
			$table->smallInteger('score', 1);
			$table->text('message');
			$table->smallInteger('state', 1);
			$table->unsignedBigInteger('game_id');
			$table->unsignedBigInteger('user_id');
			$table->foreign('game_id')->references('id')->on('game');
			$table->foreign('user_id')->references('id')->on('user');
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
		// Delete tables with foreign key before
		Schema::drop('contact');
		Schema::drop('image');

		// And delete tables without foreign key
		Schema::drop('game');
		Schema::drop('user');
		Schema::drop('user_token');
		Schema::drop('game_user');
		Schema::drop('achievement');
		Schema::drop('user_achievement');
		Schema::drop('game_witness');
	}
}