<?php

namespace App\Models;

use App\Enums\TransferStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferCommande extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => TransferStatus::class,
    ];

    protected $guarded = [];

    public function originalCommande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }

    public function newCommande()
    {
        return $this->belongsTo(Commande::class, 'new_commande_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function newClient()
    {
        return $this->belongsTo(Client::class, 'new_client_id');
    }

    public function transferCommandeArticles()
    {
        return $this->hasMany(TransferCommandeArticle::class);
    }
}
