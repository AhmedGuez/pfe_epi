<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionFringe extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function refFringe()
    {
        return $this->belongsTo(RefFringe::class);
    }
}
