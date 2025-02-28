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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offer_id'); // Foreign key to offers table
            $table->unsignedBigInteger('user_id');
            $table->decimal('total_amount' , 10,2); // Total amount 
            $table->string('to_city');
            $table->string('to_street');
            $table->decimal('order_price', 10, 2); // Price of the order
            //$table->decimal('offer_price', 10, 2); // Price of the offer
            $table->string('description')->nullable(); 
            $table->enum('status', ['pending', 'processing', 'completed', 'canceled'])->default('pending'); // Order status
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
