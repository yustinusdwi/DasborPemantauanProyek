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
        Schema::create('kontraks', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kontrak');
            $table->date('tanggal');
            $table->date('batas_akhir_kontrak');
            $table->text('uraian');
            $table->string('harga_total');
            $table->string('dokumen_kontrak')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontraks');
    }
};
