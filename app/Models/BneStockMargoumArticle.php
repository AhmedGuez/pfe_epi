<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BneStockMargoumArticle extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bneStockMargoum()
    {
        return $this->belongsTo(BneStockMargoum::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
