<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the clients that this user is associated with.
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_user')
                    ->withPivot('role', 'is_primary')
                    ->withTimestamps();
    }

    /**
     * Get the primary client for this user.
     */
    public function primaryClient()
    {
        return $this->belongsTo(Client::class, 'id', 'user_id');
    }

    /**
     * Check if user has access to a specific client.
     */
    public function hasClientAccess($clientId, $role = null)
    {
        $query = $this->clients()->where('client_id', $clientId);
        
        if ($role) {
            $query->wherePivot('role', $role);
        }
        
        return $query->exists();
    }

    /**
     * Get the role for a specific client.
     */
    public function getClientRole($clientId)
    {
        $client = $this->clients()->where('client_id', $clientId)->first();
        return $client ? $client->pivot->role : null;
    }

    /**
     * Check if user is a client (has any client relationship).
     */
    public function isClient()
    {
        return $this->clients()->exists();
    }

    /**
     * Check if user has a specific role in any client relationship.
     */
    public function hasClientRole($role)
    {
        return $this->clients()->wherePivot('role', $role)->exists();
    }
}
