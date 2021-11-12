<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Evaluation extends Model
{
    use SoftDeletes;
    use Userstamps;
    
    protected $table = 'evaluations';

    protected $fillable = [
        'title',
        'status',
        'faculty_id',
        'start_date',
        'end_date',
        'description',
    ];

    public function evaluationStudents()
    {
        return $this->hasMany('App\Models\EvaluationStudent', 'evaluation_id');
    }

    public function faculty()
    {
        return $this->belongsTo('App\Models\Faculty', 'faculty_id');
    }
}
