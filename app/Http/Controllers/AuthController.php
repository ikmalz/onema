<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class AuthController extends Controller
{
    public function auth()
    {
        return view('home.login');
    }

    public function post(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Akun tidak ditemukan.',
            ]);
        }

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'password' => 'Password salah.',
            ]);
        }

        $request->session()->regenerate();
        return redirect()->intended('home');
    }


    public function showRegistrationForm()
    {
        return view('home.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|min:5',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);


        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        auth()->login($user);

        return redirect()->route('login');
    }



    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('home');
    }

    public function switchAccount($accountId)
    {
        $user = User::find($accountId);

        if ($user) {
            Auth::login($user);
            return redirect()->route('home');
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

    public function deleteProfilePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo_path) {
            Storage::delete('public/' . $user->profile_photo_path);

            $user->update(['profile_photo_path' => null]);
        }

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }

    public function getLoggedInUser()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada pengguna yang sedang login.'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function getAllUsers()
    {
        $users = User::all();

        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }
}
