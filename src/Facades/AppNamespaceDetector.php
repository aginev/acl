<?php namespace Fos\Acl\Facades;

use Illuminate\Support\Facades\Facade;

class AppNamespaceDetector extends Facade {

	protected static function getFacadeAccessor() {
		return 'app_namespace_detector';
	}
}