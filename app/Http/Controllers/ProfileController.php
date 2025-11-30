<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required','string','max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required','email','max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile berhasil diperbarui!');
    }

    public function showPasswordForm()
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request)
{
    $user = auth()->user();

    // Validasi form
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed', // pastikan ada input new_password_confirmation
    ]);

    // Cek password lama
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->with('error', 'Password lama tidak sesuai.');
    }

    // Hash password baru dan simpan
    $user->password = Hash::make($request->new_password);
    $user->save();

    // Optional: logout user lama lalu login kembali otomatis
    auth()->login($user);

    return redirect()->route('profile.index')->with('success', 'Password berhasil diubah! Anda sekarang bisa login dengan password baru.');
}

}