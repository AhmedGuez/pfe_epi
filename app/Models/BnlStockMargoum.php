<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnlStockMargoum extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Define the relationship with the Client model
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Define the relationship with the BnlStockMargoumArticle model
    public function articles()
    {
        return $this->hasMany(BnlStockMargoumArticle::class, 'bnl_stock_margoum_id');
    }
}
