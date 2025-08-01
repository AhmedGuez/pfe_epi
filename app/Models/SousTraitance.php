<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousTraitance extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relationship with SousTraitanceArticle
     */
    public function articles()
    {
        return $this->hasMany(SousTraitanceArticle::class);
    }
    
}
