<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BncMatierePremiere extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function articles()
    {
        return $this->hasMany(BncArticle::class, 'bnc_matiere_premiere_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function articleMatierePremiere()
    {
        return $this->belongsTo(ArticleMatierePremiere::class, 'article_matiere_premiere_id');
    }
}
