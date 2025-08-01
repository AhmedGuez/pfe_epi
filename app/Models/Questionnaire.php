<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Questionnaire extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    
    protected $guarded = [];
     public function employe()
    {
        return $this->belongsTo(Employees::class, 'employe_id');
    }
}
