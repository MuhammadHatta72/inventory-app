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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique()->comment('Customer code - alphanumeric only');
            $table->string('name', 200)->comment('Customer name');
            $table->text('full_address')->comment('Complete address');
            $table->string('province', 100)->comment('Province');
            $table->string('city', 100)->comment('City');
            $table->string('district', 100)->comment('Kecamatan');
            $table->string('village', 100)->comment('Kelurahan');
            $table->string('postal_code', 10)->comment('Postal code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
