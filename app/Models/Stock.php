<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function taille()
    {
        return $this->belongsTo(Taille::class, 'taille_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
 
}
