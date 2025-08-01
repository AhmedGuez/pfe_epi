<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleMatierePremiere extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }
    

    public function stockMatierePremieres()
    {
        return $this->hasMany(StockMatierePremiere::class, 'article_matiere_premiere_id');
    }

    public function arivages()
    {
        return $this->hasMany(ArivageMatierePremiereArticle::class, 'article_matiere_premiere_id');
    }

    public function articleMatierePremiere()
    {
        return $this->belongsTo(ArticleMatierePremiere::class);
    }
    
}
