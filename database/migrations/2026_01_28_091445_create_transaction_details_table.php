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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->string('invoice_number', 50)->comment('Reference to invoice');
            $table->string('product_code', 50)->comment('Product code from products table');
            $table->string('product_name', 200)->comment('Product name snapshot');
            $table->integer('qty')->comment('Quantity');
            $table->decimal('price', 15, 2)->comment('Price (can be modified from master)');
            $table->decimal('discount_1', 15, 2)->default(0)->comment('First discount');
            $table->decimal('discount_2', 15, 2)->default(0)->comment('Second discount');
            $table->decimal('discount_3', 15, 2)->default(0)->comment('Third discount');
            $table->decimal('net_price', 15, 2)->comment('Price after all discounts');
            $table->decimal('subtotal', 15, 2)->comment('Net price * qty');
            $table->timestamps();

            $table->index('transaction_id');
            $table->index('invoice_number');
            $table->index('product_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
