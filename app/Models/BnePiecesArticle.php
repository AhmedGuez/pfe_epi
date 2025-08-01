<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BnePiecesArticle extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $guarded = [];

    public function bnePiece()
    {
        return $this->belongsTo(BnePieces::class, 'bne_piece_id');
    }

    /**
     * Relationship: An article belongs to a piece.
     */
    public function piece()
    {
        return $this->belongsTo(Pieces::class, 'piece_id');
    }

}
