<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Department extends Model
{
    use SoftDeletes;
    use Userstamps;
    
    protected $table = 'departments';

    protected $fillable = [
        'name',
    ];
}
