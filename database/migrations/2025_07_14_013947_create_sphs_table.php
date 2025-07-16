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
        Schema::create('sphs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_sph');
            $table->string('subkontraktor')->nullable();
            $table->string('nama_proyek')->nullable();
            $table->date('tanggal');
            $table->text('uraian');
            $table->string('harga_total');
            $table->json('dokumen_sph')->nullable();
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
        Schema::dropIfExists('sphs');
    }
};
