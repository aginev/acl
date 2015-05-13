<?php namespace Fos\Acl\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['role_title', 'role_description'];

	public function permissions() {
		return $this->belongsToMany('\Fos\Acl\Http\Models\Permission');
	}

}
