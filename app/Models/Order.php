<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'payment_method',
        'payment_status',
        'pp_transaction_id',
        'pp_client_tx_id',
        'pp_raw',
        'deposit_proof_path',
        'deposited_at',
        'verified_at',
        'contact',
        'address',
        'subtotal',
        'shipping_cost',
        'total',
    ];

    protected $casts = [
        'status'       => OrderStatus::class,
        'contact'      => 'array',
        'address'      => 'array',
        'pp_raw'       => 'array',
        'deposited_at' => 'datetime',
        'verified_at'  => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
