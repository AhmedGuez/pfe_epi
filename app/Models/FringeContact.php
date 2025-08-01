<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FringeContact extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sousTraitanceControlleArticles()
    {
        return $this->hasMany(SousTraitanceControlleArticle::class, 'fringe_contact_id');
    }

    public function sousTraitance()
    {
        return $this->belongsTo(SousTraitance::class, 'sous_traitance_id');
    }

    public function sousTraitanceNumber()
    {
        return $this->sousTraitance->sous_traitance_number ?? 'N/A';
    }


    public function frangePayementArticles()
    {
        return $this->hasMany(FrangePayementArticle::class);
    }
}
