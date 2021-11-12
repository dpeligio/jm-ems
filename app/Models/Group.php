<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Group extends Model
{
    use SoftDeletes;
    use Userstamps;
    
    protected $table = 'groups';

    protected $fillable = [
        'name',
        'percentage',
        'priority',
        'active',
        'group_for',
    ];

    public function questionGroup()
    {
        return $this->hasMany('App\Models\QuestionGroup', 'group_id');
    }
}
