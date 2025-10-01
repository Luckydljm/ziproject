<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DetailUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
        'unit_kerja',
        'jabatan',
        'foto',     // Hanya nama file
        'user_id',
    ];

    /**
     * Relasi: detail user dimiliki oleh satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Akses URL foto user.
     * Jika ada, ambil dari storage 'public/profiles'.
     * Jika tidak ada, gunakan gambar default.
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists('profiles/' . $this->foto)) {
            return asset('storage/profiles/' . $this->foto);
        }

        // Path default jika foto tidak ada
        return asset('assets/img/profiles/user.png');
    }
}