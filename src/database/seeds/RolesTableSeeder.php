<?php

namespace Fos\Acl\Database\Seeds;

use Fos\Acl\Commands\SetPermissions;
use Fos\Acl\Http\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesCommands;

class RolesTableSeeder extends Seeder
{
    use DispatchesCommands;

    public function run()
    {
        Model::unguard();

        // Create no permissions role
        Role::create([
            'role_title' => 'No Permissions',
            'role_description' => 'No Permissions'
        ]);

        // Create all permissions role
        $admin = Role::create([
            'role_title' => 'Admin',
            'role_description' => 'All Permissions'
        ]);

        // Assign all permission to the admin
        $this->dispatch(new SetPermissions([$admin->id]));
    }
}
