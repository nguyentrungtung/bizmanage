<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('packages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->string('type')->default('biz');
			$table->string('name');
			$table->string('domain')->unique();
			$table->string('account');
			$table->string('password');
			$table->datetime('expiry_time');
			$table->enum('status', ['trial', 'paid'])->default('trial');
			$table->boolean('active')->default(1);
			$table->boolean('installed')->default(0);
			$table->datetime('uptodate_at')->nullable();
			$table->text('settings')->nullable();
			$table->boolean('internal')->default(0);
			$table->text('configs')->nullable();
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
		Schema::drop('packages');
	}

}

