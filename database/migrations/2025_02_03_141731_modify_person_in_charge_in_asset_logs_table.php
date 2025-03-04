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
        Schema::table('asset_logs', function (Blueprint $table) {
            //
            $table->string('person_in_charge')->nullable()->change(); // ✅ Make it nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_logs', function (Blueprint $table) {
            //
        });
    }
};
