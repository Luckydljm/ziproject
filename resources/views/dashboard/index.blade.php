@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="content container-fluid">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Home</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">
                                {{ Auth::user()->role === 'Frontliner' ? 'Frontliner' : 'Kepala Cabang' }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Menu untuk Frontliner --}}
            @if (Auth::user()->role === 'Frontliner')
                <div class="row mb-5">
                    <div class="col-md-12 mb-5">
                        <div class="profile-header shadow">
                            <div class="row align-items-center">
                                <div class="col-auto profile-image">
                                    <a href="#">
                                        <img class="rounded-circle" alt="User Image"
                                            src="{{ Auth::user()->detail->foto_url ?? asset('assets/img/profiles/user.png') }}" />
                                    </a>
                                </div>
                                <div class="col ms-md-n2 profile-user-info">
                                    <h4 class="user-name mb-0">Hallo,
                                        {{ Auth::user()->detail->nama ?? Auth::user()->username }}!</h4>
                                    <div class="about-text">Skor Bulan Ini {{ $skorBulanIni }} Poin</div>
                                    @php
                                        $rating = 5; // rating 0-5
                                    @endphp
                                    <div class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($rating >= $i)
                                                <i class="fas fa-star" style="color: gold;"></i>
                                            @elseif ($rating > $i - 1)
                                                <i class="fas fa-star-half-alt" style="color: gold;"></i>
                                            @else
                                                <i class="far fa-star" style="color: gold;"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-menu">
                            <ul class="nav nav-tabs nav-tabs-solid">
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between bg-warning p-3">
                                            <span class="text-uppercase">Statistik Pribadi</span>
                                        </h5>
                                        <div class="row">
                                            <p class="col-sm-2 text-muted mb-0 mb-sm-3">Momen Tercatat</p>
                                            <p class="col-sm-10"> : {{ $totalMoment }}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-2 text-muted mb-0 mb-sm-3">Top Kategori</p>
                                            <p class="col-sm-10"> : {{ $topKategoriName }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between bg-warning p-3">
                                            <span class="text-uppercase">Leaderboard Mingguan</span>
                                        </h5>

                                        @foreach ($leaderboard as $rank => $item)
                                            <div class="row mb-2 align-items-center">
                                                <p class="fw-bold mb-0 mb-sm-3">
                                                    {{ $rank + 1 }}. <img class="rounded-circle"
                                                        src="{{ $item->foto ? asset('storage/' . $item->foto) : asset('assets/img/profiles/user.png') }}"
                                                        width="50" alt="User Image" />
                                                    {{ $item->nama ?? $item->username }} - Poin:
                                                    {{ $item->poin }}
                                                </p>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row mb-5">
                    <div class="col-md-12 mb-5">
                        <div class="profile-header shadow">
                            <div class="row align-items-center">
                                <div class="col-auto profile-image">
                                    <a href="#">
                                        <img class="rounded-circle" alt="User Image"
                                            src="{{ Auth::user()->detail->foto_url ?? asset('assets/img/profiles/user.png') }}" />
                                    </a>
                                </div>
                                <div class="col ms-md-n2 profile-user-info">
                                    <h4 class="user-name mb-0">Hallo,
                                        {{ Auth::user()->detail->nama ?? Auth::user()->username }}!</h4>
                                    <div class="about-text">NIP. {{ Auth::user()->detail->nip }}
                                    </div>
                                    <div class="about-text">{{ Auth::user()->detail->jabatan }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-menu">
                            <ul class="nav nav-tabs nav-tabs-solid">
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between bg-warning p-3">
                                            <span class="text-uppercase">Leaderboard Mingguan</span>
                                        </h5>
                                        @foreach ($leaderboard as $rank => $item)
                                            <div class="row mb-2 align-items-center">
                                                <p class="fw-bold mb-0 mb-sm-3">
                                                    {{ $rank + 1 }}. <img class="rounded-circle"
                                                        src="{{ $item->foto ? asset('storage/' . $item->foto) : asset('assets/img/profiles/user.png') }}"
                                                        width="50" alt="User Image" />
                                                    {{ $item->nama ?? $item->username }} - Poin:
                                                    {{ $item->poin }}
                                                </p>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
