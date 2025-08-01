<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taille extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }


    public function stocks()
    {
        return $this->hasMany(Stock::class, 'taille_id');
    }

}
