<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendStockFringe extends Model
{
    use HasFactory;

    protected $fillable = [
        'creation_date',
        'created_by',
        'total',
        'status',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function articles()
    {
        return $this->hasMany(SendStockFringeArticle::class);
    }
}
