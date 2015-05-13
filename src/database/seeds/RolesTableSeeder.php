<?php

use Fos\Acl\Http\Models\Permission;
use Fos\Acl\Http\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RolesTableSeeder extends Seeder {

	public function run() {
		Model::unguard();

		Role::create([
			'role_title' => 'No Permissions',
			'role_description' => 'No Permissions'
		]);

		$admin = Role::create([
			'role_title' => 'Admin',
			'role_description' => 'All Permissions'
		]);

		$permissions = Permission::all();
		$admin->permissions()->attach($permissions->lists('id'));
	}
}