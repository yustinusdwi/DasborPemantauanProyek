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
        Schema::create('lois', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_loi');
            $table->date('tanggal');
            $table->date('batas_akhir_loi');
            $table->string('no_po')->nullable();
            $table->unsignedBigInteger('kontrak_id')->nullable();
            $table->string('nama_proyek');
            $table->string('harga_total');
            $table->json('berkas_loi')->nullable();
            $table->timestamps();
            
            $table->foreign('kontrak_id')->references('id')->on('kontraks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lois');
    }
};
