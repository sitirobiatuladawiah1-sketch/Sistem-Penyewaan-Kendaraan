<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AutentikasiController extends Controller
{
    public function landing() { return view('welcome'); }

    public function showRegister() { return view('autentikasi.register'); }

    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'no_telp' => 'required',
            'alamat' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($request->password);
        User::create($validated);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat!');
    }

    public function showLogin() { return view('autentikasi.login'); }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $defaultRedirect = Auth::user()->isAdmin()
                ? route('admin.dashboard')
                : route('dashboard');

            return redirect()->intended($defaultRedirect);
        }

        return back()->withErrors(['email' => 'Email/Password salah.']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}