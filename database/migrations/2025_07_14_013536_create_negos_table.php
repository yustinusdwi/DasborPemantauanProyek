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
        Schema::create('negos', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_nego');
            $table->string('subkontraktor')->nullable();
            $table->string('nama_proyek')->nullable();
            $table->date('tanggal');
            $table->text('uraian');
            $table->string('harga_total');
            $table->json('dokumen_nego')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negos');
    }
};
