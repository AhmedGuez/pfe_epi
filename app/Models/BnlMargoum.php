<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnlMargoum extends Model
{
    use HasFactory;

    protected $guarded = [] ; 

 
    public function bnlMargoumArticles()
    {
        return $this->hasMany(BnlMargoumArticle::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
}
