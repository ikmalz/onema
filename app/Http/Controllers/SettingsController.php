<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SettingsController extends Controller
{
    public function settings()
    {
        $theme = session('theme', 'light');
        $language = session('locale', 'en');
        return view('home.settings', compact('theme', 'language'));
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark',
            'language' => 'required|in:en,id',
        ]);

        session(['theme' => $request->theme]);
        session(['locale' => $request->language]);

        App::setLocale($request->language);

        return response()->json(['message' => 'Settings saved successfully']);
    }

    public function updateTheme(Request $request)
    {
        $theme = $request->input('theme');
        session(['theme' => $theme]);
        return redirect()->back();
    }

    public function setTheme(Request $request)
    {
        $request->validate(['theme' => 'required|in:light,dark']);
        session(['theme' => $request->theme]);

        return response()->json(['message' => 'Theme updated successfully']);
    }

    public function changeTheme(Request $request)
    {
        $request->validate(['theme' => 'required|string']);
        session(['theme' => $request->theme]);

        return response()->json(['success' => true]);
    }

    public function changeLanguage(Request $request)
    {
        $request->validate(['language' => 'required|in:en,id']);
        session(['locale' => $request->language]);

        App::setLocale($request->language);

        return response()->json(['message' => 'Language changed successfully']);
    }
}
