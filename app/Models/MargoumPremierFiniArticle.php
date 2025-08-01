<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MargoumPremierFiniArticle extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function margoumPremierFini()
    {
        return $this->belongsTo(MargoumPremierFini::class);
    }

    public function commande()
    {
        return $this->belongsTo(MargoumPremierFini::class, 'commande_id');
    }
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

}
