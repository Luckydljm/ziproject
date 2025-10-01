<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RekapMoment;

class UserController extends Controller
{
    /**
     * Tampilkan list pengguna dengan role Frontliner
     */
    public function index()
    {
        $users = User::where('role', 'Frontliner')->get();
        return view('dashboard.users', compact('users'));
    }

    /**
     * Tampilkan histori moment pengguna tertentu
     */
    public function showHistori(User $user)
    {
        $moments = RekapMoment::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.histori', compact('user', 'moments'));
    }
}