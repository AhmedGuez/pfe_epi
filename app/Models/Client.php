<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    public function transferCommandes()
    {
        return $this->hasMany(TransferCommande::class, 'client_id');
    }

    public function receivedTransferCommandes()
    {
        return $this->hasMany(TransferCommande::class, 'new_client_id');
    }

    public function bnlStockMargoums()
    {
        return $this->hasMany(BnlStockMargoum::class);
    }

}
