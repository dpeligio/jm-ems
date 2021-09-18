<?php

namespace App\Models\Configuration\RolePermission;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Role extends Model
{
	use SoftDeletes;
	use Userstamps;
	
	protected $table = 'roles';

	public function permissions()
	{
		return $this->belongsToMany('App\Models\RolePermission\RolePermission')->withTimestamps();
	}

}
