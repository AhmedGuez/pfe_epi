<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BneMatierePremiereArticle extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bnsMatierePremiere()
    {
        return $this->belongsTo(BneMatierePremiere::class);
    }

    public function article()
    {
        return $this->belongsTo(ArticleMatierePremiere::class, 'article_matiere_premiere_id');
    }

    public function categorie()
    {
        return $this->belongsTo(Category::class);
    }
}
