<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $logoPath = public_path('images/logo.png');
        $hasLogo = file_exists($logoPath);

        return view('settings.index', compact('hasLogo'));
    }

    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $dir = public_path('images');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $request->file('logo')->move($dir, 'logo.png');

        return back()->with('success', 'Logo berhasil diupload.');
    }
}
