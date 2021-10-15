<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Auth;

class UserFileAttachment extends Model
{
    use SoftDeletes;
    use Userstamps;
    
	protected $table = 'user_file_attachments';

	protected $fillable = [
		'user_id',
		'file_attachment_id',
    ];
    
    public function file_attachment()
	{
		if(Auth::user()->hasrole('System Administrator')){
			return $this->belongsTo('App\Models\FileAttachment', 'file_attachment_id')->withTrashed();
		}else{
			return $this->belongsTo('App\Models\FileAttachment', 'file_attachment_id');
		}
	}

	public function user()
	{
		if(Auth::user()->hasrole('System Administrator')){
			return $this->belongsTo('App\Models\User', 'user_id')->withTrashed();
		}else{
			return $this->belongsTo('App\Models\User', 'user_id');
		}
	}
}
