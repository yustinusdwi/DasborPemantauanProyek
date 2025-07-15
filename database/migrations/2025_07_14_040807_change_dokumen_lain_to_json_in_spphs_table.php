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
        Schema::table('spphs', function (Blueprint $table) {
            $table->json('dokumen_lain')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spphs', function (Blueprint $table) {
            $table->text('dokumen_lain')->nullable()->change();
        });
    }
};
