<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapMoment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapMomentExport;

class RekapMomentController extends Controller
{
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
        // Validasi input dasar
        $rules = [
            'nm_nasabah' => 'required|string|max:255',
            'cif' => 'required|numeric|unique:rekap_moment,cif',
            'tgl_lahir' => 'required|date_format:d-m-Y',
            'no_hp' => 'required|string|max:20',
            'moments' => 'required|in:Empowered Care Moment,Special Day Moment',
            'deskripsi' => 'nullable|string',
            'foto_moment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ];

        // Jika moment BUKAN "Special Day Moment", wajib isi tanggal mulai & selesai
        if ($request->moments !== 'Special Day Moment') {
            $rules['tgl_mulai'] = 'required|date_format:d-m-Y';
            $rules['tgl_selesai'] = 'required|date_format:d-m-Y|after_or_equal:tgl_mulai';
        }

        $request->validate($rules, [
            'cif.unique' => 'CIF sudah terdaftar.',
            'foto_moment.max' => 'Ukuran foto maksimal 1MB.',
            'tgl_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
        ]);

        // Format tanggal lahir
        $tgl_lahir = Carbon::createFromFormat('d-m-Y', $request->tgl_lahir)->format('Y-m-d');

        // Format tanggal mulai dan selesai hanya jika moment bukan "Special Day Moment"
        $tgl_mulai = null;
        $tgl_selesai = null;

        if ($request->moments !== 'Special Day Moment') {
            $tgl_mulai = Carbon::createFromFormat('d-m-Y', $request->tgl_mulai)->format('Y-m-d');
            $tgl_selesai = Carbon::createFromFormat('d-m-Y', $request->tgl_selesai)->format('Y-m-d');
        }

        // Upload foto jika ada
        $fotoName = null;
        if ($request->hasFile('foto_moment')) {
            $file = $request->file('foto_moment');
            $fotoName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->storeAs('moment', $fotoName, 'public');
        }

        // Simpan ke database
        RekapMoment::create([
            'nm_nasabah' => $request->nm_nasabah,
            'cif' => $request->cif,
            'tgl_lahir' => $tgl_lahir,
            'no_hp' => $request->no_hp,
            'moments' => $request->moments,
            'deskripsi' => $request->deskripsi,
            'foto_moment' => $fotoName,
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
     * Hitung statistik dashboard
     */
    public function dashboardStats()
    {
        $userId = Auth::id();
        $now = Carbon::now();

        $skorBulanIni = RekapMoment::where('user_id', $userId)
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();

        $totalMoment = RekapMoment::where('user_id', $userId)->count();

        $topKategori = RekapMoment::where('user_id', $userId)
            ->select('moments', DB::raw('count(*) as total'))
            ->groupBy('moments')
            ->orderByDesc('total')
            ->first();
        $topKategoriName = $topKategori?->moments ?? '-';

        $leaderboard = $this->getLeaderboardMingguan();

        return [
            'skorBulanIni' => $skorBulanIni,
            'totalMoment' => $totalMoment,
            'topKategoriName' => $topKategoriName,
            'leaderboard' => $leaderboard,
        ];
    }

    /**
     * Ambil leaderboard top 3 minggu ini
     */
    public function getLeaderboardMingguan()
    {
        $now = Carbon::now();
        $startOfWeek = $now->startOfWeek()->format('Y-m-d H:i:s');
        $endOfWeek = $now->endOfWeek()->format('Y-m-d H:i:s');

        $leaderboard = RekapMoment::select('user_id', DB::raw('count(*) as poin'))
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('user_id')
            ->orderByDesc('poin')
            ->limit(3)
            ->get()
            ->map(function ($item) {
                $user = \App\Models\User::with('detail')->find($item->user_id);
                $item->username = $user->username ?? '-';
                $item->nama = $user->detail->nama ?? '-';
                $item->foto = $user->detail->foto ? 'profiles/' . $user->detail->foto : null;
                return $item;
            });

        return $leaderboard;
    }

    public function export()
    {
        $user = Auth::user();

        if ($user->role === 'Frontliner') {
            $moments = RekapMoment::where('user_id', $user->id)->get();
        } elseif ($user->role === 'Kepala Cabang') {
            $moments = RekapMoment::all();
        } else {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return Excel::download(new RekapMomentExport($moments), 'Histori_Moment_' . now()->format('Ymd_His') . '.xlsx');
    }
}