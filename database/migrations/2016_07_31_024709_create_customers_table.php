<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table)
		{
			$table->increments('id');
			
			$table->string('name');
			$table->string('email')->unique();
			$table->string('phone')->nullable();
			$table->enum('sex', ['', 'Nam', 'Nữ'])->default('');
			$table->date('dob')->nullable();
			$table->string('company')->nullable();
			$table->string('address')->nullable();
			$table->string('city')->nullable();
			$table->text('note')->nullable();
			$table->softDeletes();
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
		Schema::drop('customers');
	}

}
