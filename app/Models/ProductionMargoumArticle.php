<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionMargoumArticle extends Model
{
    use HasFactory;

    protected $casts = [
        'employee_name' => 'array', // Cast the JSON column as an array
    ];
    protected $guarded = [];
    public function productionMargoumMachine()
    {
        return $this->belongsTo(ProductionMargoumMachine::class);
    }
    public function taille()
    {
        return $this->belongsTo(Taille::class);
    }

    // public function employee()
    // {
    //     return $this->belongsTo(Employees::class);
    // }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
