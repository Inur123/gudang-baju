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
        Schema::create('sizes', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('name', 50)->nullable(false); // VARCHAR(50) NOT NULL
            $table->enum('label', ['dewasa', 'anak'])->nullable(false); // ENUM('dewasa', 'anak') NOT NULL
            $table->boolean('is_custom')->default(false); // BOOLEAN NOT NULL DEFAULT FALSE
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sizes');
    }
};
