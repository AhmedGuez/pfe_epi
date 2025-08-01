<?php

namespace App\Models;

use App\Enums\DemandeAchatStatus;
use Filament\Notifications\Actions\Action;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Filament\Notifications\Notification;


class DemandeAchat extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;


    protected $guarded = [];

    protected $casts = [
        'status' => DemandeAchatStatus::class,
    ];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
    }

    
}
