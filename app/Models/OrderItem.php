<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_title',
        'sku',
        'unit_price',
        'qty',
        'line_total',
        'tax_amount',
        'discount_amount',
    ];

    protected $casts = [
        'unit_price'      => 'float',
        'line_total'      => 'float',
        'tax_amount'      => 'float',
        'discount_amount' => 'float',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
