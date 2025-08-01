<?php

namespace App\Models;

use App\Enums\ContractType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;
    protected $guarded = [];


  
    protected $casts = [
        'contract_type' => ContractType::class,
    ];
  // In Employees model
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    

    public function pointages()
    {
        return $this->hasMany(Pointage::class, 'employee_id'); // Adjust 'employee_id' if necessary
    }

    public function advances()
    {
        return $this->hasMany(Advance::class, 'employee_id'); // Adjust 'employee_id' if necessary
    }

    public function primes()
    {
        return $this->hasMany(Prime::class, 'employee_id'); // Adjust 'employee_id' if necessary
    }

    public function questionnaires()
    {
        return $this->hasMany(Questionnaire::class, 'employe_id');
    }
}
