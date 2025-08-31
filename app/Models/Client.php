<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Client extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the primary user associated with this client.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all users associated with this client.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'client_user')
                    ->withPivot('role', 'is_primary')
                    ->withTimestamps();
    }

    /**
     * Get the primary user for this client.
     */
    public function primaryUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get users with a specific role.
     */
    public function usersWithRole($role)
    {
        return $this->users()->wherePivot('role', $role);
    }

    /**
     * Check if a user has access to this client.
     */
    public function hasUserAccess($userId, $role = null)
    {
        $query = $this->users()->where('user_id', $userId);
        
        if ($role) {
            $query->wherePivot('role', $role);
        }
        
        return $query->exists();
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }
    
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    public function transferCommandes()
    {
        return $this->hasMany(TransferCommande::class, 'client_id');
    }

    public function receivedTransferCommandes()
    {
        return $this->hasMany(TransferCommande::class, 'new_client_id');
    }

    public function bnlStockMargoums()
    {
        return $this->hasMany(BnlStockMargoum::class);
    }
}
