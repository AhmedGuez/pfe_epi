<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionMargoumMachine extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function productionMargoum()
    {
        return $this->belongsTo(ProductionMargoum::class);
    }

    // Relationship: A ProductionMargoumMachine has many ProductionMargoumArticle
    public function articles()
    {
        return $this->hasMany(ProductionMargoumArticle::class);
    }
}
