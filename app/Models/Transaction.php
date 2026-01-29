<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        // static::creating(function ($transaction) {
        //     if (empty($transaction->invoice_number)) {
        //         // Use transaction_date if available, otherwise use current date
        //         $date = $transaction->transaction_date ?? now();
        //         $transaction->invoice_number = self::generateInvoiceNumber($date);
        //     }
        // });
    }

    /**
     * Generate invoice number with format INV/YYMM/0001
     * 
     * Format:
     * - INV = invoice prefix code
     * - YYMM = year (last 2 digits) + month (2 digits), e.g., 2507 for July 2025
     * - 0001 = sequential number (resets every month)
     * 
     * @param \DateTime|string|Carbon|null $date Transaction date (default: current date)
     * @return string Invoice number in format INV/YYMM/0001
     */
    public static function generateInvoiceNumber($date = null): string
    {
        // Use provided date or current date
        if ($date == null) {
            $date = now();
        } elseif (is_string($date)) {
            $date = Carbon::parse($date);
        } elseif (!$date instanceof Carbon && !$date instanceof \DateTime) {
            $date = now();
        } else {
            // Ensure it's a Carbon instance
            $date = Carbon::instance($date);
        }

        // Format: YYMM (2 digits year + 2 digits month)
        // Example: 2507 for July 2025, 2407 for July 2024
        $yearMonth = $date->format('ym');
        $prefix = "INV/{$yearMonth}/";

        // Get last invoice number for the same month
        $lastInvoice = self::where('invoice_number', 'like', $prefix . '%')
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($lastInvoice) {
            // Extract sequence number (last 4 digits)
            $lastSequence = (int) substr($lastInvoice->invoice_number, -4);
            $newSequence = $lastSequence + 1;
        } else {
            // First invoice for this month
            $newSequence = 1;
        }

        // Format sequence number with leading zeros (4 digits)
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
