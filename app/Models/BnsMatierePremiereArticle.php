<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnsMatierePremiereArticle extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function bnsMatierePremiere()
    {
        return $this->belongsTo(BnsMatierePremiere::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function articleMatierePremiere()
    {
        return $this->belongsTo(ArticleMatierePremiere::class, 'article_matiere_premiere_id');
    }

    public function article()
    {
        return $this->belongsTo(ArticleMatierePremiere::class, 'article_matiere_premiere_id');
    }


}
