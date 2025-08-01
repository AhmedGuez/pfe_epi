<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackToStockArticle extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function backToStock()
    {
        return $this->belongsTo(BackToStock::class, 'back_to_stock_id');
    }

    public function categorie()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function article()
    {
        return $this->belongsTo(ArticleMatierePremiere::class, 'article_matiere_premiere_id');
    }
}
