<?php namespace Fos\Acl\Http\Helpers;

use Illuminate\Console\AppNamespaceDetectorTrait;

class AppNamespaceDetector {

	use AppNamespaceDetectorTrait;

	/**
	 * Store application namespace
	 *
	 * @var string
	 */
	public static $app_namespace;

	/**
	 * Get application namespace
	 *
	 * @return string
	 */
	public function getNamespace() {
		// Lazy loading
		if (!self::$app_namespace) {
			self::$app_namespace = $this->getAppNamespace();
		}

		return self::$app_namespace;
	}
}