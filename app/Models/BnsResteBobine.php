<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnsResteBobine extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Define the relationship with BnsResteBobineArticle
    public function articles()
    {
        return $this->hasMany(BnsResteBobineArticle::class, 'bns_reste_bobine_id');
    }

}
