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
            $table->string('subkontraktor')->nullable()->after('nomor_spph');
            $table->string('nama_proyek')->nullable()->after('subkontraktor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spphs', function (Blueprint $table) {
            $table->dropColumn(['subkontraktor', 'nama_proyek']);
        });
    }
};
