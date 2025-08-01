<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Pieces extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $guarded = [];
    

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function interventions()
    {
        return $this->belongsToMany(Intervention::class, 'intervention_pieces', 'piece_id', 'intervention_id')
            ->withPivot('quantite')
            ->withTimestamps();
    }

}
