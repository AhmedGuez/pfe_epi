<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Delivery extends Model
{
     protected $fillable = [
        'bnl_number',
        'type',
        'client_id',
        'employee_id',
        'from_depot_id',
        'to_depot_id',
        'car_number',
        'delivery_date',
        'status'
    ];

   protected static function boot()
{
    parent::boot();

    static::creating(function ($delivery) {
        $lastId = self::max('id') ?? 0;
        $delivery->bnl_number = 'BNL-' . ($lastId + 1);
    });
}

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }

    public function fromDepot()
    {
        return $this->belongsTo(Depot::class, 'from_depot_id');
    }

    public function toDepot()
    {
        return $this->belongsTo(Depot::class, 'to_depot_id');
    }
    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'delivery_items')
            ->withPivot('quantity');
    }

    protected static function booted()
    {
        static::deleting(function ($delivery) {
            $delivery->items()->delete();
        });
    }

    public function deliveredBy()
{
    return $this->belongsTo(User::class, 'delivered_by');
}

    public function items()
    {
        return $this->hasMany(DeliveryItems::class);
    }
}