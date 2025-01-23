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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_type');
            $table->string('brand');
            $table->string('product_name');
            $table->string('product_number');
            $table->date('date_purchased');
            $table->decimal('price', 10, 2);
            $table->text('notes')->nullable();
            $table->string('person_in_charge');
            $table->string('hardware_location')->nullable();
            $table->boolean('is_borrowable')->default(false);
            $table->json('uploaded_files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
