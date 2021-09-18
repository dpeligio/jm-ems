<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class UserStudent extends Model
{
	use SoftDeletes;
	use Userstamps;
    
    protected $table = 'user_students';

    protected $fillable = [
        'user_id',
        'student_id'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function student(){
        return $this->belongsTo('App\Models\Student', 'student_id');
    }
}
