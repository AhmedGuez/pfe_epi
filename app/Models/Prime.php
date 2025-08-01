<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prime extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'amount', 'date', 'raison'];

    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }
}
