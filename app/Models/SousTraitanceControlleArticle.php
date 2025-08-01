<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousTraitanceControlleArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'sous_traitance_controlle_id',
        'ref_fringe_id',
        'fringe_contact_id',
        'approved_qty',
        'rejected_qty',
        'status',
        'notes',
    ];

    public function controlle()
    {
        return $this->belongsTo(SousTraitanceControlle::class, 'sous_traitance_controlle_id');
    }

    public function refFringe()
{
    return $this->belongsTo(RefFringe::class, 'ref_fringe_id');
}

public function fringeContact()
{
    return $this->belongsTo(FringeContact::class, 'fringe_contact_id');
}
}
