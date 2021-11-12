<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class EvaluationStudent extends Model
{
    use SoftDeletes;
    use Userstamps;
    
    protected $table = 'evaluation_students';

    protected $fillable = [
        'evaluation_id',
        'student_id',
        'positive_comments',
        'negative_comments',
    ];

    public function evaluation()
    {
        return $this->belongsTo('App\Models\Evaluation', 'evaluation_id');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id');
    }

    public function evaluationStudentReponses()
    {
        return $this->belongsTo('App\Models\EvaluationStudentReponse', 'evaluation_student_id');
    }
}
