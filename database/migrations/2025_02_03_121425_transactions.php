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
            $table->id(); // Primary key
            $table->unsignedBigInteger('order_id'); // Foreign key for order
            $table->string('payment_method'); // Payment method (e.g., credit card, PayPal)
            $table->date('date'); // Transaction date
            $table->enum('status', ['pending', 'completed', 'failed', 'canceled'])->default('pending'); // Transaction status
            $table->timestamps();

            // FK
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
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
