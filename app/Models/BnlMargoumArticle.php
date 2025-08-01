<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnlMargoumArticle extends Model
{
    use HasFactory;

    protected $guarded = [] ; 

    public function margoumFini()
    {
        return $this->belongsTo(StockMargoumFini::class);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function stockMargoumFini()
{
    return $this->belongsTo(StockMargoumFini::class, 'stock_margoum_fini_id');
}

}
