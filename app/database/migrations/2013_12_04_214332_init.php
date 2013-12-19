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
			$table->smallInteger('objet', 1);
			$table->text('message');
			$table->timestamps();
		});

		Schema::create('image', function($table)
		{
			$table->bigIncrements('id');
			$table->string('url');
			$table->string('server_path');
			$table->smallInteger('type', 2);
			$table->timestamps();
		});

		/**
		 * Tables with foreign key
		 */

		Schema::create('game', function($table)
		{
			$table->bigIncrements('id');
			$table->string('title');
			$table->string('link');
			$table->text('description');
			$table->unsignedBigInteger('image_id');
			$table->foreign('image_id')->references('id')->on('image')->onDelete('cascade');
			$table->timestamps();
		});

		Schema::create('user', function($table)
		{
			$table->bigIncrements('id');
			$table->string('username');
			$table->smallInteger('gender', 1);
			$table->string('link');
			$table->string('email')->unique();
			$table->string('password', 32);
			$table->date('birthday_at');
			$table->smallInteger('type', 1);
			$table->smallInteger('state', 1);
			$table->boolean('is_newsletter');
			$table->bigInteger('facebook_id');
			$table->unsignedBigInteger('photo_id');
			$table->foreign('photo_id')->references('id')->on('image')->onDelete('cascade');
			$table->timestamps();
		});

		Schema::create('game_user', function($table)
		{
			$table->bigIncrements('id');
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
			$table->string('reference');
			$table->integer('score');
			$table->boolean('is_unlock');
			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('user');
			$table->timestamps();
		});

		Schema::create('witness', function($table)
		{
			$table->bigIncrements('id');
			$table->smallInteger('score', 1);
			$table->text('message');
			$table->smallInteger('state', 1);
			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('user');
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
		Schema::drop('user_game');
		Schema::drop('achievement');
		Schema::drop('witness');
		Schema::drop('game_witness');
	}
}