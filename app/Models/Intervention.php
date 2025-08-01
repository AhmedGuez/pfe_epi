<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Intervention extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    public function machine()
    {
        return $this->belongsTo(Machines::class, 'machine_id'); // Ensure the column is correct
    }
    
    public function technicien()
    {
        return $this->belongsTo(Technicien::class, 'technicien_id'); // Ensure the column is correct
    }
    
    public function interventionPieces()
    {
        return $this->hasMany(InterventionPieces::class, 'intervention_id');
    }

}




