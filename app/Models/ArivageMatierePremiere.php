<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArivageMatierePremiere extends Model
{
    use HasFactory;
    // protected $casts = [
    //     'creation_date' => 'datetime:Y-m-d',
    // ];
    protected $guarded = [];

    public function articles()
    {
        return $this->hasMany(ArivageMatierePremiereArticle::class, 'arivage_matiere_premiere_id');
    }

    public function bnsResteBobineArticles()
    {
        return $this->hasMany(BnsResteBobineArticle::class);
    }
   
}
