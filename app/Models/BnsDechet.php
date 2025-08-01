<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BnsDechet extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function articles()
    {
        return $this->hasMany(BnsDechetArticle::class);
    }
    public function contact()
{
    return $this->belongsTo(DechetContact::class, 'dechet_contact_id');
}
}
