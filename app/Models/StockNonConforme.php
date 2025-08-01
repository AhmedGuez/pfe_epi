<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockNonConforme extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function refFringe()
    {
        return $this->belongsTo(RefFringe::class, 'ref_fringe_id');
    }

    public function fringeContact()
    {
        return $this->belongsTo(FringeContact::class, 'fringe_contact_id');
    }


}
