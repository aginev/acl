<?php namespace Fos\Acl\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\View;

abstract class AclController extends BaseController
{
    use DispatchesCommands, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('acl');

        $validation_errors_format = config('acl.validation_errors_format');
        if ($validation_errors_format) {
            $shared = View::shared('errors');
            if ($shared) {
                $shared->setFormat($validation_errors_format);
            }
        }
    }
}
