<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendStockFringeArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'send_stock_fringe_id',
        'ref_fringe_id',
        'contact_name',
        'qty',
    ];

    protected $casts = [
        'contact_name' => 'array',
        'qty' => 'decimal:3',
    ];

    public function sendStockFringe()
    {
        return $this->belongsTo(SendStockFringe::class);
    }

    public function refFringe()
    {
        return $this->belongsTo(RefFringe::class);
    }
}
