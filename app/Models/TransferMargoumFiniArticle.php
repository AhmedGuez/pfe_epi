<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferMargoumFiniArticle extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function transfer()
    {
        return $this->belongsTo(TransferMargoumFini::class, 'transfer_margoum_fini_id');
    }

    // Belongs to Article
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
    

    public function stockMargoumFini()
    {
        return $this->belongsTo(StockMargoumFini::class, 'article_id', 'article_id');
    }
}
