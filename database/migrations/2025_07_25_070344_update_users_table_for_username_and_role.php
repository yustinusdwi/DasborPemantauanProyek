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
        Schema::table('users', function (Blueprint $table) {
            // Drop kolom yang tidak diperlukan
            $table->dropColumn(['name', 'email', 'email_verified_at', 'remember_token']);
            
            // Tambah kolom username dan role
            $table->string('username')->unique()->after('id');
            $table->enum('role', ['admin', 'pengguna'])->default('pengguna')->after('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan
            $table->dropColumn(['username', 'role']);
            
            // Kembalikan kolom yang dihapus
            $table->string('name')->after('id');
            $table->string('email')->unique()->after('name');
            $table->timestamp('email_verified_at')->nullable()->after('email');
            $table->rememberToken()->after('password');
        });
    }
};
