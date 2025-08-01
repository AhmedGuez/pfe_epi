<?php

namespace App\Models;

use App\Traits\RenderCommandeArticlesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeArticle extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_transferred_to'); // Adjust the foreign key if necessary
    }
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
