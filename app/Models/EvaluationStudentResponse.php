<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class EvaluationStudentResponse extends Model
{
    use SoftDeletes;
    use Userstamps;
    
    protected $table = 'evaluation_student_reponses';

    protected $fillable = [
        'evaluation_student_id',
        'question',
        'answer',
    ];

    public function evaluationStudent()
    {
        return $this->belongsTo('App\Models\EvaluationStudent', 'evaluation_student_id');
    }
}
