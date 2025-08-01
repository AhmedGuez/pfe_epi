<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonSortieBobineSr extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bonSortieBobineSrArticle()
    {
        return $this->hasMany(BonSortieBobineSrArticle::class, 'bon_sortie_bobine_sr_id');
    }
}
