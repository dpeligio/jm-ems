<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class QuestionGroup extends Model
{
    use SoftDeletes;
    use Userstamps;

    protected $table = 'questions_groups';

    protected $fillable = [
        'question_id',
        'group_id',
        'priority',
    ];

    public function question()
    {
        return $this->belongsTo('App\Models\Questions', 'question_id');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Groups', 'group_id');
    }
}
