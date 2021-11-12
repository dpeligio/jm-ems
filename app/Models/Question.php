<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Question extends Model
{
    use SoftDeletes;
    use Userstamps;
    
    protected $table = 'questions';

    protected $fillable = [
        'question',
        'is_active'
    ];
}
