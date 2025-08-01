<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferCommandeArticle extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function transferCommande()
    {
        return $this->belongsTo(TransferCommande::class, 'transfer_commande_id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }
}
