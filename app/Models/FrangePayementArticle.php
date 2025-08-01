<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrangePayementArticle extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function frangePayement()
    {
        return $this->belongsTo(FrangePayement::class);
    }
    public function fringeContact()
    {
        return $this->belongsTo(FringeContact::class, 'fringe_contact_id');
    }
    public function refFringe()
    {
        return $this->belongsTo(RefFringe::class);
    }

    public function sousTraitance()
    {
        return $this->belongsTo(SousTraitance::class);
    }
    public function payement()
{
    return $this->belongsTo(FrangePayement::class);
}

public function contact()
{
    return $this->belongsTo(FringeContact::class, 'fringe_contact_id');
}

}
