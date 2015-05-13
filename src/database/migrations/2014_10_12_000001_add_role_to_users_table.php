<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoleToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		//ALTER TABLE  `users` ADD  `role_id` INT NOT NULL DEFAULT  '0' AFTER  `id`

		Schema::table('users', function ($table) {
			$table->integer('role_id')->unsigned();
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('users', function ($table) {
			$table->dropIndex('role_user_index');
			$table->dropColumn('role_id');
		});
	}
}
