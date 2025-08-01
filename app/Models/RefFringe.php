<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class RefFringe extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $fillable = [
        'ref',
        'image',
    ];

    public function stockFringes()
    {
        return $this->hasMany(StockFringe::class);
    }

    public function articles()
    {
        return $this->hasMany(SendStockFringeArticle::class);
    }


    public function sousTraitanceArticles()
    {
        return $this->hasMany(SousTraitanceArticle::class);
    }

    public function frangePayementArticles()
    {
        return $this->hasMany(FrangePayementArticle::class);
    }

}
