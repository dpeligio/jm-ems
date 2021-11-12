<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Course extends Model
{
    use SoftDeletes;
    use Userstamps;
    
    protected $table = 'courses';

    protected $fillable = [
        'course_code',
        'title',
        'description',
    ];
}
