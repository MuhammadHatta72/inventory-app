<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    /**
     * Check if product has transactions
     */
    public function hasTransactions(): bool
    {
        return $this->transactionDetails()->exists();
    }

    /**
     * Get transaction details for this product
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'product_code', 'code');
    }

    /**
     * Reduce stock after transaction
     */
    public function reduceStock(int $quantity): bool
    {
        if ($this->stock < $quantity) {
            return false;
        }

        $this->stock -= $quantity;
        return $this->save();
    }

    /**
     * Check if stock is available
     */
    public function isStockAvailable(int $quantity): bool
    {
        return $this->stock >= $quantity;
    }
}
