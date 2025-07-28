<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sphs', function (Blueprint $table) {
            if (!Schema::hasColumn('sphs', 'is_published')) {
                $table->boolean('is_published')->default(false)->after('dokumen_lain');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sphs', function (Blueprint $table) {
            if (Schema::hasColumn('sphs', 'is_published')) {
                $table->dropColumn('is_published');
            }
        });
    }
};
