<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function commandeArticles()
    {
        return $this->hasMany(CommandeArticle::class);
    }

    public function margoumFiniArticles()
    {
        return $this->hasMany(MargoumPremierFiniArticle::class);
    }

    public function bnsMargoumArticles()
    {
        return $this->hasMany(BnsMargoumArticle::class);
    }

    public function bnlMargoumArticles()
    {
        return $this->hasMany(BnlMargoumArticle::class);
    }

    public function transferCommandeArticles()
    {
        return $this->hasMany(TransferCommandeArticle::class, 'article_id');
    }

    public function stockMargoumArticles()
    {
        return $this->hasMany(StockMargoumArticle::class);
    }

    public function stockMargoums()
    {
        return $this->belongsToMany(StockMargoum::class, 'stock_margoum_articles')
                    ->withPivot('nombre_de_pieces')
                    ->withTimestamps();
    }

    public function bnlStockMargoumArticles()
    {
        return $this->hasMany(BnlStockMargoumArticle::class);
    }

    public function bneStockMargoumArticles()
    {
        return $this->hasMany(BneStockMargoumArticle::class);
    }

    public function bnsStockMargoumArticles()
    {
        return $this->hasMany(BnsStockMargoumArticle::class);
    }


    public function transferArticles()
    {
        return $this->hasMany(TransferMargoumFiniArticle::class, 'article_id');
    }
}