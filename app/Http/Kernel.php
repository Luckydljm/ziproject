<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Middleware global yang dijalankan di setiap request.
     */
    protected $middleware = [
        // Mengecek apakah aplikasi dalam mode maintenance
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,

        // Validasi ukuran POST (misalnya upload file besar)
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // Menghapus spasi ekstra dari input
        \App\Http\Middleware\TrimStrings::class,

        // Mengubah string kosong menjadi null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * Middleware groups.
     * Biasanya untuk web dan api.
     */
    protected $middlewareGroups = [
        'web' => [
            // Cookie & session
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,

            // Bagikan error validasi ke view
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,

            // Proteksi CSRF
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,

            // Binding model ke route
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // Batasi request API (60 request per menit per user)
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Middleware individual yang bisa dipakai di route.
     */
    protected $routeMiddleware = [
        // Autentikasi user (hanya user login yang bisa akses route tertentu)
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,

        // Redirect jika user sudah login
        'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,

        // Konfirmasi password (untuk aksi sensitif)
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,

        // Validasi tanda tangan URL
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,

        // Batasi request
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // Binding model ke route
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,

        // 🔑 Custom: Middleware cek role (Frontliner / Kepala Cabang)
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ];
}