<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class StudentSection extends Model
{
	use SoftDeletes;
	use Userstamps;
    
    protected $table = 'student_sections';

    protected $fillable = [
        'section_id',
        'student_id'
    ];

    public function student(){
        return $this->belongsTo('App\Models\Student', 'student_id');
    }

    public function section(){
        return $this->belongsTo('App\Models\Section', 'section_id');
    }
}
