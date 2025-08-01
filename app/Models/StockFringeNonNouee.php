<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class StockFringeNonNouee extends Model implements HasMedia
{
    use HasFactory;

    use InteractsWithMedia;

    protected $fillable = ['ref_fringe_id', 'qty'];

    public function refFringe()
    {
        return $this->belongsTo(RefFringe::class, 'ref_fringe_id');
    }
}
