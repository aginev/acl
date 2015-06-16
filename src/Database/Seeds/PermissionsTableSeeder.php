<?php

namespace Aginev\Acl\Database\Seeds;

use Aginev\Acl\Commands\SetPermissions;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Bus\DispatchesCommands;

class PermissionsTableSeeder extends Seeder
{
    use DispatchesCommands;

    public function run()
    {
        $this->dispatch(new SetPermissions());
    }
}
