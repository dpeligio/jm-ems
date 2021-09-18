<?php

namespace App\Models\Configuration\RolePermission;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class RolePermission extends Model
{
	use SoftDeletes;
	use Userstamps;

	protected $table = 'role_has_permissions';

	protected $fillable = [
		'permission_id',
		'model_type',
		'model_id',
	];

	public function role()
	{
		return $this->belongsTo('App\Models\Configuration\RolePermission\Role', 'role_id', 'id');
	}
}
