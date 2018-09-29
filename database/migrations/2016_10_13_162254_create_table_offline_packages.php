<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOfflinePackages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('offline_packages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->integer('package_id')->unsigned();
			$table->string('code')->unique();
			$table->datetime('expiry_date');
			$table->boolean('active')->default(0);
			$table->datetime('activate_time')->nullable();
			$table->string('ip_address')->nullable();
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
		Schema::drop('offline_packages');
	}

}
