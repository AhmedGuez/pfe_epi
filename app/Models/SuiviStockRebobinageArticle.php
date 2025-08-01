<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuiviStockRebobinageArticle extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function suiviStockRebobinage()
    {
        return $this->belongsTo(SuiviStockRebobinage::class);
    }

}
