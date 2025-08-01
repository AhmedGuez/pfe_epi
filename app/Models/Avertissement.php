<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avertissement extends Model
{
    use HasFactory;

    protected $guarded = [] ;

    public function employe()
    {
        return $this->belongsTo(Employees::class, 'employe_id');
    }
}
