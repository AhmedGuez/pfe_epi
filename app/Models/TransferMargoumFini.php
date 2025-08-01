<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferMargoumFini extends Model
{
    use HasFactory;

    protected $guarded = [];

   public function articles()
{
    return $this->hasMany(TransferMargoumFiniArticle::class, 'transfer_margoum_fini_id');
}

public function stockMargoumFini()
{
    return $this->belongsTo(StockMargoumFini::class, 'article_id');
}

}
