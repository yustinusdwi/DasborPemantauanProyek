<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Hardcoded users
        $hardcodedUsers = [
            [
                'username' => 'admin',
                'password' => 'admin123',
                'role' => 'admin'
            ],
            [
                'username' => 'pengguna',
                'password' => 'pengguna123',
                'role' => 'pengguna'
            ],
            // Contoh menambah user baru:
            // [
            //     'username' => 'manager',
            //     'password' => 'manager123',
            //     'role' => 'admin'
            // ],
            // [
            //     'username' => 'staff',
            //     'password' => 'staff123',
            //     'role' => 'pengguna'
            // ]
        ];

        $username = $request->input('username');
        $password = $request->input('password');

        // Cek hardcoded users
        foreach ($hardcodedUsers as $user) {
            if ($user['username'] === $username && $user['password'] === $password) {
                // Cari atau buat user di database
                $dbUser = User::firstOrCreate(
                    ['username' => $user['username']],
                    [
                        'username' => $user['username'],
                        'password' => Hash::make($user['password']),
                        'role' => $user['role']
                    ]
                );

                Auth::login($dbUser);
        $request->session()->regenerate();

                // Redirect berdasarkan role
                if ($dbUser->role === 'admin') {
                    return redirect()->intended(route('admin-landing', absolute: false));
                } else {
        return redirect()->intended(route('dashboard', absolute: false));
                }
            }
        }

        // Jika tidak ditemukan, throw error
        throw \Illuminate\Validation\ValidationException::withMessages([
            'username' => 'Username atau password salah.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
