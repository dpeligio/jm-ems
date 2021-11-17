<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use App\Models\EvaluationFaculty;

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

    public function getFacultyName()
	{
		$name = "N/A";
		if($this->id){
			$name = $this->first_name.' '.
				(is_null($this->middle_name) ? '' : $this->middle_name[0].'. ').
				$this->last_name;
		}
		return $name;
    }

    public static function getName()
	{
		$name = "N/A";
		if($this->id){
			$name = $this->first_name.' '.
				(is_null($this->middle_name) ? '' : $this->middle_name[0].'. ').
				$this->last_name.
				' '.$this->suffix;
		}
		return $name;
    }
    
    public function facultyEvaluations()
    {
        return EvaluationFaculty::where(['faculty_id', $this->id]);
    }
    
    /** 
     * $format = 'f-m-l'
     * $format = 'l-f-m'
     * $format = 'l-f-M'
     */
    public function fullname($format)
	{
        $format = explode('-', $format);
        $name = "";
        for ($i=0; $i < count($format); $i++) { 
            switch ($format[$i]) {
                case 'f':
                    if($i == 0)
                        $name .= $this->first_name;
                    elseif($i == 1)
                        $name .= $this->first_name;
                    break;
                case 'm':
                    if(!is_null($this->middle_name)){
                        if($i == 1){
                            $name .= ' '.$this->middle_name[0].'. ';
                        }else{
                            $name .= ' '.$this->middle_name[0].'. ';
                        }
                    }
                    break;
                case 'M':
                    if(!is_null($this->middle_name)){
                        if($i == 1){
                            $name .= ' '.$this->middle_name[0].'. ';
                        }else{
                            $name .= ' '.$this->middle_name[0].'. ';
                        }
                    }
                    break;
                case 'l':
                    if($i == 0){
                        $name .= $this->last_name.', ';
                    }elseif($i == 2){
                        $name .= ' '.$this->last_name;
                    }
                    break;
                case 's':
                    // if($i == 3){
                        $name .= $this->suffix;
                    // }
                    break;
                
                default:
                $name = $this->first_name.' '.
                    (is_null($this->middle_name) ? '' : $this->middle_name[0].'. ').
                    $this->last_name.
				    ' '.$this->suffix;
                    break;
            }
        }
		
		return $name;
    }
    
    public function avatar()
    {
        $avatar = 'images/user/default/male.jpg';
        if(!is_null($this->image)){
            $avatar = 'images/user/'.$this->image;
        }
        return $avatar;
    }

}
