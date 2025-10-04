<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['status'];

    protected $casts = [
        'content' => 'array',
        'address' => 'array',
        'pp_raw'  => 'array',
        'status'  => OrderStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // CORREGIDO: hasMany
    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    // Helper para obtener el último envío (por created_at)
    public function latestShipment()
    {
        return $this->hasOne(Shipment::class)->latestOfMany(); // usa created_at por defecto
        // Si prefieres por id: ->latestOfMany('id')
    }
}
