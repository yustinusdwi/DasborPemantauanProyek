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
        Schema::table('bapps', function (Blueprint $table) {
            $table->string('tipe')->default('internal')->after('berkas_bapp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bapps', function (Blueprint $table) {
            $table->dropColumn('tipe');
        });
    }
};
