<?php
namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // Tentukan apakah 'login' berupa email atau username
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Persiapkan kredensial login
        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        // Proses login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Ambil user yang login
            $user = Auth::user();

            // Arahkan berdasarkan level_user
            switch ($user->level_user) {
                case 'admin':
                    return redirect()->intended('/dashboard-admin');
                case 'petugas':
                    return redirect()->intended('/dashboard-petugas');
                case 'anggota':
                    return redirect()->intended('/dashboard-anggota');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors([
                        'login' => 'Level user tidak dikenali.',
                    ]);
            }
        }

        // Gagal login
        return back()->withErrors([
            'login' => 'Login gagal. Email/Username atau Password salah.',
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

        return redirect('/login');
    }
}
