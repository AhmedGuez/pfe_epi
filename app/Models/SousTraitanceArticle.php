<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousTraitanceArticle extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relationship with SousTraitance
     */
    public function sousTraitance()
    {
        return $this->belongsTo(SousTraitance::class);
    }
  
    /**
     * Relationship with RefFringe
     */
    public function fringe()
    {
        return $this->belongsTo(StockFringeNonNouee::class, 'ref_fringe_id');
    }

    /**
     * Relationship with FringeContact
     */
    public function refFringe()
    {
        return $this->belongsTo(RefFringe::class, 'ref_fringe_id');
    }
    
    public function fringeContact()
    {
        return $this->belongsTo(FringeContact::class, 'fringe_contact_id');
    }
    
}
