<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'full_address',
        'province',
        'city',
        'district',
        'village',
        'postal_code',
    ];

    /**
     * Check if customer has transactions
     */
    public function hasTransactions(): bool
    {
        return $this->transactions()->exists();
    }

    /**
     * Get transactions for this customer
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'customer_code', 'code');
    }

    /**
     * Get full address formatted
     */
    public function getFullAddressFormattedAttribute(): string
    {
        return sprintf(
            "%s, %s, %s, %s, %s %s",
            $this->full_address,
            $this->village,
            $this->district,
            $this->city,
            $this->province,
            $this->postal_code
        );
    }
}
