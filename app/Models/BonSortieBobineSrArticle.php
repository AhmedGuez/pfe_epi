<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonSortieBobineSrArticle extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function bonSortieBobineSr()
    {
        return $this->belongsTo(BonSortieBobineSr::class, 'bon_sortie_bobine_sr_id');
    }

    public function articleMatierePremiere()
    {
        return $this->belongsTo(ArticleMatierePremiere::class, 'article_matiere_premiere_id');
    }
}
