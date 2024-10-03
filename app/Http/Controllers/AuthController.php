<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Tambahkan ini


class AuthController extends Controller
{
    public function auth()
    {
        return view('home.login');
    }

    public function post(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('home.register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|min:5',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);


        // Buat pengguna baru
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Login pengguna
        auth()->login($user);

        // Redirect ke halaman home
        return redirect()->route('login');
    }



    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login');
    }

    public function switchAccount($accountId)
    {
        $user = User::find($accountId);

        if ($user) {
            Auth::login($user);
            return redirect()->route('home');  // Redirect ke halaman home setelah login
        }

        return back()->withErrors(['account' => 'Account not found.']);
    }

    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();


        if ($user->profile_photo_path) {
            Storage::delete('public/' . $user->profile_photo_path);
        }

        $path = $request->file('profile_photo')->store('profile_photos', 'public');

        $user->update(['profile_photo_path' => $path]);


        return back()->with('success', 'Profile photo updated successfully.');
    }
}
