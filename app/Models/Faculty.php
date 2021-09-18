<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Faculty extends Model
{
    use SoftDeletes;
    use Userstamps;
    
    protected $fillable = [
        'faculty_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'contact_number',
        'address'
    ];

    public function user() {
        return $this->hasOne('App\Models\UserFaculty', 'faculty_id');
    }

    public static function getFacultyName($facultyID)
	{
		$faculty = self::find($facultyID);
		$name = "N/A";
		if($faculty){
			$name = $faculty->first_name.' '.
				(is_null($faculty->middle_name) ? '' : $faculty->middle_name[0].'. ').
				$faculty->last_name;
		}
		return $name;
	}
}
