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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('offer_name');

            //$table->string('custom_user_id');  
            $table->foreignid('user_id')->references('id')->on('users')->onDelete('cascade')->nullable();

           // $table->string('unit_id');  
            $table->foreignid('unit_id')->references('id')->on('units')->onDelete('cascade');

            //$table->string('cat_id');
            $table->foreignid('cat_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('image_path')->nullable(false); // Add the image column
            $table->integer('amount')->nullable(false); 
            $table->integer('unit_price')->nullable(false); 
            $table->integer('status'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};