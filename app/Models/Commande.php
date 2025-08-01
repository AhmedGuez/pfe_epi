<?php

namespace App\Models;

use App\Enums\CommandeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => CommandeStatus::class,
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // public function margoumFiniArticles()
    // {
    //     return $this->hasMany(MargoumFiniArticle::class);
    // }

    public function commandeArticles()
    {
        return $this->hasMany(CommandeArticle::class);
    }
    
    public function transferCommandeArticles()
    {
        return $this->hasMany(TransferCommandeArticle::class, 'commande_id');
    }


    
}
