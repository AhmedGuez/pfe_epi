<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnsMargoumSemiFini extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bnsMargoumSemiFiniArticles()
    {
        return $this->hasMany(BnsMargoumSemiFiniArticles::class);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }
    
    public function articles()
{
    return $this->hasMany(BnsMargoumSemiFiniArticles::class, 'bns_margoum_semi_fini_id');
}

}
