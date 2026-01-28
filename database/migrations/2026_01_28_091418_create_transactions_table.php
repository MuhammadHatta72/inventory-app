<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 50)->unique()->comment('Format: INV/YYMM/0001');
            $table->string('customer_code', 50)->comment('Customer code from customers table');
            $table->string('customer_name', 200)->comment('Customer name snapshot');
            $table->text('customer_address')->comment('Customer address snapshot');
            $table->date('transaction_date')->comment('Transaction date');
            $table->decimal('total', 15, 2)->default(0)->comment('Total transaction amount');
            $table->timestamps();

            $table->index('invoice_number');
            $table->index('customer_code');
            $table->index('transaction_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
