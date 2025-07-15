<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Polyfill untuk openssl_cipher_iv_length jika ekstensi openssl tidak aktif
        if (!function_exists('openssl_cipher_iv_length')) {
            function openssl_cipher_iv_length($method) {
                // Nilai default untuk AES-256-CBC adalah 16
                if ($method === 'AES-256-CBC') {
                    return 16;
                }
                // Tambahkan metode lain jika perlu
                return false;
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
