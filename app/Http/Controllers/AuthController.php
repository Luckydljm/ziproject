<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DetailUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // Tampilkan form login
    public function loginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors([
                'username' => 'Username tidak terdaftar.',
            ])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah.',
            ])->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('dashboard');
    }

    // Tampilkan form register
    public function registerForm()
    {
        return view('auth.register');
    }

    // Proses register
    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'role' => 'required',
            'nama' => 'required',
            'nip' => 'required',
            'unit_kerja' => 'required',
            'jabatan' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024', // Maks 1MB
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'foto.max' => 'Ukuran foto maksimal 1MB.',
            'foto.image' => 'File harus berupa gambar.',
        ]);

        $fotoName = null;
        if ($request->hasFile('foto')) {
            $fotoFile = $request->file('foto');

            // Buat nama file unik: timestamp + random + ekstensi
            $fotoName = time() . '_' . uniqid() . '.' . $fotoFile->getClientOriginalExtension();

            // Simpan file di storage/app/public/profiles
            $fotoFile->storeAs('profiles', $fotoName, 'public');
        }

        // Simpan user
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Simpan detail user, hanya nama file disimpan di DB
        DetailUser::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'unit_kerja' => $request->unit_kerja,
            'jabatan' => $request->jabatan,
            'foto' => $fotoName, // Hanya nama file
            'user_id' => $user->id,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}