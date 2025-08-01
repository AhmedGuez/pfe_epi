<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnlStockMargoumArticle extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Define the relationship with the BnlStockMargoum model
    public function bnlStockMargoum()
    {
        return $this->belongsTo(BnlStockMargoum::class);
    }

    // Define the relationship with the Article model
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
