<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];


public function bnsMatierePremiereArticles()
{
    return $this->hasMany(BnsMatierePremiereArticle::class);
}

public function arivageMatierePremiereArticles()
{
    return $this->hasMany(ArivageMatierePremiereArticle::class);
}

public function parent()
{
    return $this->belongsTo(Category::class, 'parent_id');
}

// Define the children relationship
public function children()
{
    return $this->hasMany(Category::class, 'parent_id');
}

public function stockMatierePremieres()
{
    return $this->hasMany(StockMatierePremiere::class);
}

public function articleMatierePremieres()
{
    return $this->hasMany(ArticleMatierePremiere::class, 'categorie_id');
}

public function bnsResteBobineArticles()
{
    return $this->hasMany(BnsResteBobineArticle::class, 'categorie_id');
}


}
