<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnsFrangeArticle extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bnsFrange()
    {
        return $this->belongsTo(BnsFrange::class);
    }

    /**
     * Get the reference fringe associated with this article.
     */
    public function refFringe()
    {
        return $this->belongsTo(RefFringe::class);
    }

}
