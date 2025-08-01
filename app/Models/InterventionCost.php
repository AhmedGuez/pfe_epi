<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterventionCost extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function intervention()
    {
        return $this->belongsTo(Intervention::class, 'intervention_id');
    }

    public function technicien()
    {
        return $this->belongsTo(Technicien::class, 'technicien_id');
    }
}
