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
        Schema::table('kontraks', function (Blueprint $table) {
            $table->unsignedBigInteger('loi_id')->nullable()->after('harga_total');
            $table->foreign('loi_id')->references('id')->on('lois')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kontraks', function (Blueprint $table) {
            $table->dropForeign(['loi_id']);
            $table->dropColumn('loi_id');
        });
    }
};
