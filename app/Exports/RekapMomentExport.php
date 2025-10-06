<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapMomentExport implements FromView
{
    protected $moments;

    public function __construct($moments)
    {
        $this->moments = $moments;
    }

    public function view(): View
    {
        return view('exports.rekap_moment', [
            'moments' => $this->moments
        ]);
    }
}