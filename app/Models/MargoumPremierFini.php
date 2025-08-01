<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MargoumPremierFini extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function margoumPremierFiniArticles()
    {
        return $this->hasMany(MargoumPremierFiniArticle::class);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
    public function articles()
    {
        return $this->hasMany(MargoumPremierFiniArticle::class, 'margoum_premier_fini_id', 'id');
    }

}
