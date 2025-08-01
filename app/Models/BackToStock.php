<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackToStock extends Model
{
    use HasFactory;

    // protected $casts = [
    //     'creation_date' => 'datetime:Y-m-d',
    // ];
    protected $guarded = [];

    public function articles()
    {
        return $this->hasMany(BackToStockArticle::class, 'back_to_stock_id');
    }
}
