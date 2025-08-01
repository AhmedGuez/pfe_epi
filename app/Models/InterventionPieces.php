<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterventionPieces extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function intervention()
    {
        return $this->belongsTo(Intervention::class, 'intervention_id');
    }

    public function piece()
    {
        return $this->belongsTo(Pieces::class, 'piece_id');
    }
}
