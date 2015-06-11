<?php

namespace Fos\Acl\Commands;

use App\Commands\Command;
use Fos\Acl\Http\Helpers\RouteList;
use Fos\Acl\Http\Models\Permission;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Collection;

class AssignPermissions extends Command implements SelfHandling
{

    /**
     * Permission routes
     *
     * @var Collection
     */
    private $role_ids = [];

    /**
     * Create a new command instance.
     *
     * @param array $role_ids
     */
    public function __construct(array $role_ids)
    {
        $this->role_ids = $role_ids;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
