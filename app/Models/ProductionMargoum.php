<?php

namespace App\Models;

use App\Filament\Clusters\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionMargoum extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function machines()
    {
        return $this->hasMany(ProductionMargoumMachine::class);
    }

    public function employee()
{
    return $this->belongsTo(Employee::class, 'employee_id');
}
}
