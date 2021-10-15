<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Student extends Model
{
	use SoftDeletes;
	use Userstamps;
    
    protected $table = 'students';

    protected $fillable = [
        'student_id',
        'year_level',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'contact_number',
        'address'
    ];

    public function section() {
        return $this->hasOne('App\Models\StudentSection', 'student_id');
    }

    public function user() {
        return $this->hasOne('App\Models\UserStudent', 'student_id');
    }

    public static function getStudentName($studentID)
	{
		$student = self::find($studentID);
		$name = "N/A";
		if($student){
			$name = $student->first_name.' '.
				(is_null($student->middle_name) ? '' : $student->middle_name[0].'. ').
				$student->last_name;
		}
		return $name;
	}
}
