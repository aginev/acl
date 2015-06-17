<?php

namespace Aginev\Acl\Console;

use Aginev\Acl\Jobs\SetPermissions;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputOption;

class AclFill extends Command
{
    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'acl:fill-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill ACL permissions.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->dispatch(new SetPermissions($this->getRoleIds()));
    }

    /**
     * Parse role ids from the command option and return them as array if ids
     *
     * @return array
     */
    private function getRoleIds()
    {
        $assign_to_roles = $this->option('assign-to-roles');

        if ($assign_to_roles) {
            $role_ids = explode(',', $assign_to_roles);

            return array_map('intval', $role_ids);
        }

        return [];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];

//        return [
//            ['example', InputArgument::OPTIONAL, 'An example argument.'],
//        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['assign-to-roles', null, InputOption::VALUE_OPTIONAL, 'Comma separated list of role IDs that the permissions need to be assigned to.', null],
        ];
    }
}
