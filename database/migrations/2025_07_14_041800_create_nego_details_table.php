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
        Schema::create('nego_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nego_id');
            $table->enum('tipe', ['masuk', 'keluar', 'hasil']);
            $table->string('nomor_nego');
            $table->string('subkontraktor');
            $table->date('tanggal');
            $table->string('harga_total');
            $table->json('dokumen_nego')->nullable();
            $table->timestamps();

            $table->foreign('nego_id')->references('id')->on('negos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nego_details');
    }
}; 