<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
	use SoftDeletes;
    use Userstamps;
    
    protected $table = 'positions';

    protected $fillable = [
        'name',
    ];
}
