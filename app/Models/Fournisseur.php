<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;

    protected $table = 'fournisseurs';

    protected $fillable = [
        'nom_fournisseur',
        'adresse',
        'produit',
        'secteur',
        'adresse_mail',
        'num_tel',
        'nom_commercial',
    ];

    // Specify that 'num_tel' should be cast to an array
    protected $casts = [
        'num_tel' => 'array',
    ];


    public function demandesAchat()
    {
        return $this->hasMany(DemandeAchat::class, 'fournisseur_id');
    }
}
