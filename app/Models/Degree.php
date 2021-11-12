<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Degree extends Model
{
    use SoftDeletes;
    use Userstamps;
    
    protected $table = 'degrees';

    protected $fillable = [
        'name',
    ];
}
