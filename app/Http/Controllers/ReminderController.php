<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapMoment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReminderController extends Controller
{
    /**
     * Tampilkan kalender jadwal nasabah
     */
    public function index()
    {
        $userId = Auth::id();

        // Ambil semua nasabah yang diinput user ini
        $nasabahList = RekapMoment::where('user_id', $userId)->get();

        $events = [];

        foreach ($nasabahList as $nasabah) {
            // H-7 dari tgl_selesai
            if ($nasabah->tgl_selesai) {
                $tglSelesai = \Carbon\Carbon::parse($nasabah->tgl_selesai);
                $h7 = $tglSelesai->copy()->subDays(7);

                $events[] = [
                    'title' => 'H-7 deadline: ' . $nasabah->nm_nasabah,
                    'start' => $h7->format('Y-m-d'),
                    'className' => 'bg-danger'
                ];
            }

            // Tanggal ulang tahun
            if ($nasabah->tgl_lahir) {
                $tglLahir = \Carbon\Carbon::parse($nasabah->tgl_lahir);
                $ulangTahun = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, $tglLahir->month, $tglLahir->day);

                $events[] = [
                    'title' => 'Ulang Tahun: ' . $nasabah->nm_nasabah,
                    'start' => $ulangTahun->format('Y-m-d'),
                    'className' => 'bg-success'
                ];
            }
        }

        return view('dashboard.reminder', [
            'events' => $events
        ]);

    }
}