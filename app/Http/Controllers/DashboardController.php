<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard sesuai role
     */
    public function index()
    {
        $rekapMoment = new \App\Http\Controllers\RekapMomentController;

        $stats = $rekapMoment->dashboardStats();
        $leaderboard = $rekapMoment->getLeaderboardMingguan(); // <-- data leaderboard

        return view('dashboard.index', [
            'skorBulanIni' => $stats['skorBulanIni'],
            'totalMoment' => $stats['totalMoment'],
            'topKategoriName' => $stats['topKategoriName'],
            'leaderboard' => $leaderboard,
        ]);
    }

}