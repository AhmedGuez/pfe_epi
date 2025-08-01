<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machines extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function interventions()
    {
        return $this->hasMany(Intervention::class, 'machine_id');
    }
}
