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
        Schema::create('spphs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_spph');
            $table->date('tanggal');
            $table->date('batas_akhir_sph');
            $table->text('uraian');
            $table->json('dokumen_spph')->nullable();
            $table->json('dokumen_sow')->nullable();
            $table->json('dokumen_lain')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spphs');
    }
};
