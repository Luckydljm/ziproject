<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Field yang bisa diisi massal
    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    // Jangan tampilkan field ini saat User di-convert ke JSON
    protected $hidden = [
        'password',
    ];

    // Relasi: satu user punya satu detail user
    public function detail()
    {
        return $this->hasOne(DetailUser::class, 'user_id');
    }
}