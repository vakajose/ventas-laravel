<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    public function index()
    {
        $themes = ['light' => 'Light', 'dark' => 'Dark'];
        $languages = ['en' => 'English', 'es' => 'Español'];

        return view('settings.index', compact('themes', 'languages'));
    }

    public function changeLanguage(Request $request)
    {
        $request->validate(['language' => 'required|in:en,es']);
        Session::put('locale', $request->language);
        App::setLocale($request->language);

        return redirect()->back()->with('success', __('Language changed successfully.'));
    }

    public function changeTheme(Request $request)
    {
        $request->validate(['theme' => 'required|in:light,dark,system']);
        Session::put('theme', $request->theme);

        return redirect()->back()->with('success', __('Theme changed successfully.'));
    }
}

