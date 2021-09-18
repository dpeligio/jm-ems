<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Section extends Model
{
    use SoftDeletes;
    use Userstamps;
    
    protected $table = 'sections';

    protected $fillable = [
        'year_level',
        'name'
    ];
}
