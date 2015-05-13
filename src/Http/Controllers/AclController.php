<?php namespace Fos\Acl\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class AclController extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	public function __construct() {
		$this->middleware('auth');
		$this->middleware('acl');
	}
}
