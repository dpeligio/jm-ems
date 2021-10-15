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
        'is_verified',
        'username',
        'email',
        'password',
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

    public function file_attachments()
    {
        return $this->hasMany('App\Models\UserFileAttachment', 'user_id');
    }

    public function schoolID_image()
    {
        foreach ($this->file_attachments as $file_attachment) {
            if($file_attachment->file_attachment->subject == 'School ID validation'){
                return $file_attachment->file_attachment->file_path.'/'.$file_attachment->file_attachment->file_name;
            }
        }
        return "";
    }

}
