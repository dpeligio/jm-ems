<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Classes extends Model
{
    use SoftDeletes;
    use Userstamps;
    
    protected $table = 'classes';

    protected $fillable = [
        'course_id',
        'faculty_id',
        'school_year',
        'schedule',
    ];
}
