<?php

namespace App\Models\Configuration\RolePermission;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Permission extends Model
{
	use SoftDeletes;
	use Userstamps;

	protected $table = 'permissions';

}
