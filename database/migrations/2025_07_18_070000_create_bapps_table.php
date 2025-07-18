<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bapps', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_bapp');
            $table->string('no_po');
            $table->date('tanggal_po');
            $table->date('tanggal_terima');
            $table->string('nama_proyek');
            $table->json('berkas_bapp')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('bapps');
    }
}; 