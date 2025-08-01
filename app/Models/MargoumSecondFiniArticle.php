<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MargoumSecondFiniArticle extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function margoumSecondFini()
    {
        return $this->belongsTo(MargoumSecondFini::class);
    }

    public function commandeArticle()
    {
        return $this->belongsTo(CommandeArticle::class, 'commande_id', 'commande_id');
    }


    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
