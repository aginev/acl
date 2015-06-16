<?php namespace Aginev\Acl\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['resource', 'controller', 'method', 'description'];

    public function roles()
    {
        return $this->belongsToMany('\Aginev\Acl\Http\Models\Role');
    }
}
