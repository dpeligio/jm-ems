<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use App\Models\FileAttachment;
use App\Models\UserFileAttachment;

class User extends Authenticatable
{
    use SoftDeletes;
	use Userstamps;
    use Notifiable;
	use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar',
        'school_id_image',
        'is_verified',
        'username',
        'email',
        'password',
        'temp_password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
	{
		return $this->belongsTo('App\Models\Configuration\RolePermission\UserRole', 'id', 'model_id');
    }
    
    public function student(){
        return $this->hasOne('App\Models\UserStudent', 'user_id');
    }

    public function faculty(){
        return $this->hasOne('App\Models\UserFaculty', 'user_id');
    }

    public function userInfo()
    {
        if(isset($this->student->id)){
            return $this->student->student;
        }else{
            return $this->faculty->faculty;
        }
    }

    public function schoolIDImage()
    {
        if(!is_null($this->school_id_image)){
            return 'images/user/uploads/'.$this->school_id_image;
        }
        return 'images/no-image.png';
    }

    public function avatar()
    {

        $avatar = 'images/'.$this->userInfo()->gender.'.jpg';
        if(!is_null($this->avatar)){
            $avatar = 'images/user/avatar/'.$this->avatar;
        }
        return $avatar;
    }

}
