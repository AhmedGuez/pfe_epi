<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnsDechetArticle extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bnsDechet()
    {
        return $this->belongsTo(BnsDechet::class);
    }

    public function dechetType()
    {
        return $this->belongsTo(DechetType::class, 'dechet_type_id');
    }
}
