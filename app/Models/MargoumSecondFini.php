<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MargoumSecondFini extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function margoumSecondFiniArticles()
    {
        return $this->hasMany(MargoumSecondFiniArticle::class, 'margoum_second_fini_id');
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function articles()
    {
        return $this->hasManyThrough(Article::class, MargoumSecondFiniArticle::class, 'margoum_second_fini_id', 'id', 'id', 'article_id');
    }
}
