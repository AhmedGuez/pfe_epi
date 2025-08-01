<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMatierePremiere extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function article()
    {
        return $this->belongsTo(ArticleMatierePremiere::class, 'article_matiere_premiere_id',);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }
    
}
