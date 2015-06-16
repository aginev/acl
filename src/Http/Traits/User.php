<?php namespace Aginev\Acl\Http\Traits;

trait User
{
    public function role()
    {
        return $this->belongsTo('\Aginev\Acl\Http\Models\Role');
    }
}
