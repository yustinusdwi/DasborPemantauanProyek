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
        Schema::table('negos', function (Blueprint $table) {
            if (Schema::hasColumn('negos', 'nomor_nego')) {
                $table->dropColumn('nomor_nego');
            }
            if (Schema::hasColumn('negos', 'pengirim')) {
                $table->dropColumn('pengirim');
            }
            if (Schema::hasColumn('negos', 'tanggal')) {
                $table->dropColumn('tanggal');
            }
            if (Schema::hasColumn('negos', 'harga_total')) {
                $table->dropColumn('harga_total');
            }
            if (Schema::hasColumn('negos', 'dokumen_nego')) {
                $table->dropColumn('dokumen_nego');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('negos', function (Blueprint $table) {
            $table->string('nomor_nego')->nullable();
            $table->string('pengirim')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('harga_total')->nullable();
            $table->json('dokumen_nego')->nullable();
        });
    }
}; 