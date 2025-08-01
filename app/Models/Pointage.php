<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'hours_worked',
        'overtime_hours',
        'is_weekend',
    ];

    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }
}
