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
        // Ubah kolom dokumen_sph di tabel sphs
        if (Schema::hasTable('sphs')) {
            Schema::table('sphs', function (Blueprint $table) {
                $table->json('dokumen_sph')->nullable()->change();
            });
        }

        // Ubah kolom dokumen_nego di tabel negos
        if (Schema::hasTable('negos')) {
            Schema::table('negos', function (Blueprint $table) {
                $table->json('dokumen_nego')->nullable()->change();
            });
        }

        // Ubah kolom dokumen_kontrak di tabel kontraks
        if (Schema::hasTable('kontraks')) {
            Schema::table('kontraks', function (Blueprint $table) {
                $table->json('dokumen_kontrak')->nullable()->change();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan kolom dokumen_sph di tabel sphs
        if (Schema::hasTable('sphs')) {
            Schema::table('sphs', function (Blueprint $table) {
                $table->string('dokumen_sph')->nullable()->change();
            });
        }

        // Kembalikan kolom dokumen_nego di tabel negos
        if (Schema::hasTable('negos')) {
            Schema::table('negos', function (Blueprint $table) {
                $table->string('dokumen_nego')->nullable()->change();
            });
        }

        // Kembalikan kolom dokumen_kontrak di tabel kontraks
        if (Schema::hasTable('kontraks')) {
            Schema::table('kontraks', function (Blueprint $table) {
                $table->string('dokumen_kontrak')->nullable()->change();
        });
        }
    }
};
