<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnsResteBobineArticle extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Define the inverse relationship with BnsResteBobine
    public function bnsResteBobine()
    {
        return $this->belongsTo(BnsResteBobine::class);
    }

    // Define the relationship with ArticleMatierePremiere
    public function articleMatierePremiere()
    {
        return $this->belongsTo(ArticleMatierePremiere::class, 'article_matiere_premiere_id');
    }

    // Define the relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }
}
