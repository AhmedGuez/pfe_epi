<?php

namespace App\Models;

use App\Http\Controllers\SousTraitanceController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousTraitanceControlle extends Model
{
    use HasFactory;

    protected $fillable = [
        'sous_traitance_id',
        'date_entree',
        'status',
    ];

    public function articles()
    {
        return $this->hasMany(SousTraitanceControlleArticle::class, 'sous_traitance_controlle_id');
    }

    public function sousTraitance()
    {
        return $this->belongsTo(SousTraitance::class, 'sous_traitance_id');
    }

    public function frangePayements()
    {
        return $this->hasMany(FrangePayement::class);
    }
}
