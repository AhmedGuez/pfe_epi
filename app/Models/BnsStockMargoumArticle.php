<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnsStockMargoumArticle extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function bnsStockMargoum()
    {
        return $this->belongsTo(BnsStockMargoum::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
