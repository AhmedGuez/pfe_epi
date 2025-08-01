<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryItems extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
