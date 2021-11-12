<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class ClassStudent extends Model
{
    use SoftDeletes;
    use Userstamps;
    
    protected $table = 'class_students';

    protected $fillable = [
        'class_id',
        'student_id',
    ];
}
