<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RekapMoment extends Model
{
    use HasFactory;

    protected $table = 'rekap_moment';

    protected $fillable = [
        'nm_nasabah',
        'cif',
        'tgl_lahir',
        'no_hp',
        'moments',
        'deskripsi',
        'foto_moment',
        'tgl_mulai',
        'tgl_selesai',
        'user_id',
    ];

    // Relasi ke user yang menginput
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Akses URL foto
    public function getFotoUrlAttribute()
    {
        if ($this->foto_moment && Storage::disk('public')->exists('moment/' . $this->foto_moment)) {
            return asset('storage/moment/' . $this->foto_moment);
        }
        return asset('assets/img/default-moment.png');
    }
}