<?php

namespace Aginev\Acl\Database\Seeds;

use Aginev\Acl\Jobs\SetPermissions;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Bus\DispatchesJobs;

class PermissionsTableSeeder extends Seeder
{
    use DispatchesJobs;

    public function run()
    {
        $this->dispatch(new SetPermissions());
    }
}
