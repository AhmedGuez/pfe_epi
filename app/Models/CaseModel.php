<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseModel extends Model
{
    use HasFactory;

    protected $table = 'cases'; // Define the table explicitly
    protected $guarded = [];

    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }
}
