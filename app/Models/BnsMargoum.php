<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnsMargoum extends Model
{
    use HasFactory;
    protected $guarded = [] ; 

    public function bnsMargoumArticles()
    {
        return $this->hasMany(BnsMargoumArticle::class);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }

    
}
