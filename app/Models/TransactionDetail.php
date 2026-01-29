<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'invoice_number',
        'product_code',
        'product_name',
        'qty',
        'price',
        'discount_1',
        'discount_2',
        'discount_3',
        'net_price',
        'subtotal',
    ];

    protected $casts = [
        'qty' => 'integer',
        'price' => 'decimal:2',
        'discount_1' => 'decimal:2',
        'discount_2' => 'decimal:2',
        'discount_3' => 'decimal:2',
        'net_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($detail) {
            $detail->calculateNetPrice();
            $detail->calculateSubtotal();
        });
    }

    /**
     * Calculate net price after discounts
     * Net Price = Price - (Disc1 + Disc2 + Disc3)
     */
    public function calculateNetPrice(): void
    {
        $this->net_price = $this->price - ($this->discount_1 + $this->discount_2 + $this->discount_3);
    }

    /**
     * Calculate subtotal
     * Subtotal = Net Price * Qty
     */
    public function calculateSubtotal(): void
    {
        $this->subtotal = $this->net_price * $this->qty;
    }

    /**
     * Get transaction
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_code', 'code');
    }
}
