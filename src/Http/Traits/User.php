<?php namespace Fos\Acl\Http\Traits;

trait User {

	public function role() {
		return $this->belongsTo('\Fos\Acl\Http\Models\Role');
	}

}