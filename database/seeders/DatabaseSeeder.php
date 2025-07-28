<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create hardcoded users
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        );

        User::firstOrCreate(
            ['username' => 'pengguna'],
            [
                'username' => 'pengguna',
                'password' => Hash::make('pengguna123'),
                'role' => 'pengguna'
            ]
        );

        // Contoh menambah user baru:
        // User::firstOrCreate(
        //     ['username' => 'manager'],
        //     [
        //         'username' => 'manager',
        //         'password' => Hash::make('manager123'),
        //         'role' => 'admin'
        //     ]
        // );
        // 
       

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
