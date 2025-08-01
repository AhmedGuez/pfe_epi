<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absences extends Model
{
    use HasFactory;

    protected $fillable = [
        'employe_id',
        'date_debut',
        'date_fin',
        'duree_jours',
        'raison',
        'justification',
    ];

    public function employe()
    {
        return $this->belongsTo(Employees::class, 'employe_id');
    }
}
