<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuiviStockRebobinage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function suiviStockRebobinageArticle()
    {
        return $this->hasMany(SuiviStockRebobinageArticle::class);
    }

    public function articleMatierePremiere()
    {
        return $this->belongsTo(ArticleMatierePremiere::class, 'article_matiere_premiere_id');
    }

   
}
