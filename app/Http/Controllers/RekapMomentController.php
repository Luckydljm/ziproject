<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapMoment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class RekapMomentController extends Controller
{
    // Controller ini sudah otomatis hanya bisa diakses Frontliner melalui route middleware

    /**
     * Tampilkan form input moment nasabah
     */
    public function create()
    {
        return view('dashboard.form-moment');
    }

    /**
     * Simpan data moment nasabah
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nm_nasabah' => 'required|string|max:255',
            'cif' => 'required|numeric|unique:rekap_moment,cif',
            'tgl_lahir' => 'required|date',
            'no_hp' => 'required|string|max:20',
            'moments' => 'required|in:Empowered Care Moment,Special Day Moment',
            'deskripsi' => 'nullable|string',
            'foto_moment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'tgl_mulai' => 'date',
            'tgl_selesai' => 'date|after_or_equal:tgl_mulai',
        ], [
            'cif.unique' => 'CIF sudah terdaftar.',
            'foto_moment.max' => 'Ukuran foto maksimal 1MB.',
        ]);

        $tgl_lahir = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tgl_lahir)->format('Y-m-d');
        $tgl_mulai = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tgl_mulai)->format('Y-m-d');
        $tgl_selesai = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tgl_selesai)->format('Y-m-d');

        $fotoName = null;
        if ($request->hasFile('foto_moment')) {
            $file = $request->file('foto_moment');
            // Ubah nama file agar unik
            $fotoName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->storeAs('moment', $fotoName, 'public');
        }

        // Simpan data
        RekapMoment::create([
            'nm_nasabah' => $request->nm_nasabah,
            'cif' => $request->cif,
            'tgl_lahir' => $tgl_lahir,
            'no_hp' => $request->no_hp,
            'moments' => $request->moments,
            'deskripsi' => $request->deskripsi,
            'foto_moment' => $fotoName, // hanya nama file
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Moment nasabah berhasil ditambahkan.');
    }

    /**
     * Tampilkan histori moment
     */
    public function histori()
    {
        $user = Auth::user();

        if ($user->role === 'Frontliner') {
            $moments = RekapMoment::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->role === 'Kepala Cabang') {
            $moments = RekapMoment::orderBy('created_at', 'desc')->get();
        } else {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('dashboard.histori', compact('moments'));
    }

    /**
     * Hitung statistik dashboard untuk user saat ini
     */
    public function dashboardStats()
    {
        $userId = Auth::id();
        $now = Carbon::now();

        // Skor bulan ini (jumlah moment bulan berjalan)
        $skorBulanIni = RekapMoment::where('user_id', $userId)
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();

        // Total moment tercatat
        $totalMoment = RekapMoment::where('user_id', $userId)->count();

        // Top kategori
        $topKategori = RekapMoment::where('user_id', $userId)
            ->select('moments', DB::raw('count(*) as total'))
            ->groupBy('moments')
            ->orderByDesc('total')
            ->first();
        $topKategoriName = $topKategori?->moments ?? '-';

        // Leaderboard Mingguan Top 3
        $leaderboard = $this->getLeaderboardMingguan();

        return [
            'skorBulanIni' => $skorBulanIni,
            'totalMoment' => $totalMoment,
            'topKategoriName' => $topKategoriName,
            'leaderboard' => $leaderboard,
        ];
    }

    /**
     * Ambil Leaderboard Top 3 user berdasarkan poin minggu ini
     */
    public function getLeaderboardMingguan()
    {
        $now = \Carbon\Carbon::now();
        $startOfWeek = $now->startOfWeek()->format('Y-m-d H:i:s'); // Senin 00:00
        $endOfWeek = $now->endOfWeek()->format('Y-m-d H:i:s');     // Minggu 23:59

        // Ambil top 3 user berdasarkan jumlah moment minggu ini
        $leaderboard = \App\Models\RekapMoment::select('user_id', DB::raw('count(*) as poin'))
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('user_id')
            ->orderByDesc('poin')
            ->limit(3)
            ->get()
            ->map(function ($item) {
                $user = \App\Models\User::with('detail')->find($item->user_id);

                $item->username = $user->username;
                $item->nama = $user->detail->nama ?? null;
                $item->foto = $user->detail->foto ? 'profiles/' . $user->detail->foto : null;

                return $item;
            });


        return $leaderboard;
    }

}