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
        Schema::table('assets', function (Blueprint $table) {
            // Drop existing primary key (if any)
            $table->dropPrimary();

            // Modify the `id` column to string and set it as the new primary key
            $table->string('id')->primary()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // Revert the primary key back to the default
            $table->dropPrimary();
            $table->bigIncrements('id')->change(); // Assuming the original `id` was a big integer
        });
    }
};
