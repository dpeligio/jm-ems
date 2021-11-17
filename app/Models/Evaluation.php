<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Carbon\Carbon;

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

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function evaluationStudents()
    {
        return $this->hasMany('App\Models\EvaluationStudent', 'evaluation_id');
    }

    public function evaluationFaculties()
    {
        return $this->hasMany('App\Models\EvaluationFaculty', 'evaluation_id');
    }

    public function getStatus()
    {
        $now = Carbon::now();
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);
        $status = 'incoming';

        if($this->start_date->lt($now) && $this->end_date->gt($now)){
            $status = 'ongoing';
        }
        elseif($this->end_date->lt($now)){
            $status = 'ended';
        }
        return $status;
    }
}
