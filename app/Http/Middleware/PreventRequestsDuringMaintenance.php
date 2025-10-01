<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * Daftar URI yang boleh diakses meskipun sedang maintenance.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}