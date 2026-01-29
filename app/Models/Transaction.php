<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_code',
        'customer_name',
        'customer_address',
        'transaction_date',
        'total',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'total' => 'decimal:2',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->invoice_number)) {
                $transaction->invoice_number = self::generateInvoiceNumber();
            }
        });
    }

    /**
     * Generate invoice number with format INV/YYMM/0001
     */
    public static function generateInvoiceNumber(): string
    {
        $yearMonth = now()->format('ym'); // Format: 2501 for Jan 2025
        $prefix = "INV/{$yearMonth}/";

        // Get last invoice number for current month
        $lastInvoice = self::where('invoice_number', 'like', $prefix . '%')
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($lastInvoice) {
            // Extract sequence number
            $lastSequence = (int) substr($lastInvoice->invoice_number, -4);
            $newSequence = $lastSequence + 1;
        } else {
            $newSequence = 1;
        }

        return $prefix . str_pad($newSequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get transaction details
     */
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Get customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_code', 'code');
    }

    /**
     * Calculate and update total
     */
    public function calculateTotal(): void
    {
        $this->total = $this->details()->sum('subtotal');
        $this->save();
    }
}
