<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('transaction_id'); // Foreign key ke tabel transactions
            $table->unsignedBigInteger('clothes_id'); // Foreign key ke tabel clothes
            $table->unsignedBigInteger('size_id'); // Foreign key ke tabel sizes
            $table->integer('quantity')->nullable(false); // Jumlah barang yang ditambahkan atau dikurangi
            $table->timestamps(); // created_at dan updated_at
            // Foreign keys
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('clothes_id')->references('id')->on('clothes')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
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
