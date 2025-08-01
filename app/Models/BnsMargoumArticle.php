<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnsMargoumArticle extends Model
{
    use HasFactory;
    protected $guarded = [] ; 

    public function bnsMargoum()
    {
        return $this->belongsTo(BnsMargoum::class);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

}
