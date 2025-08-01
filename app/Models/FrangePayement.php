<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrangePayement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sousTraitanceControlle()
    {
        return $this->belongsTo(SousTraitanceControlle::class);
    }

    // Relationship with FrangePayementArticle
    public function frangePayementArticles()
    {
        return $this->hasMany(FrangePayementArticle::class);
    }

 
    public function sousTraitanceArticle()
    {
        return $this->belongsTo(SousTraitanceArticle::class);
    }
    public function articles()
{
    return $this->hasMany(FrangePayementArticle::class);
}
}
