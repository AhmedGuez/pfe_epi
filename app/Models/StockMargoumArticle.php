<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMargoumArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_margoum_id',
        'article_id',
        'nombre_de_pieces',
    ];

    public function stockMargoum()
    {
        return $this->belongsTo(StockMargoum::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
