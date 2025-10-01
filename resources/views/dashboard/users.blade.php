@extends('layouts.app')

@section('title', 'Data Pengguna')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Data Pengguna</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Pengguna</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($users as $user)
                <div class="col-md-4 mb-3">
                    <div class="card shadow h-100">
                        <div class="card-body d-flex align-items-center">
                            <img src="{{ $user->detail->foto_url ?? asset('assets/img/profiles/user.png') }}"
                                alt="{{ $user->username }}" class="rounded-circle me-3" width="50" height="50">
                            <div>
                                <h5 class="mb-1">{{ $user->detail->nama ?? $user->username }}</h5>
                                <a href="{{ route('users.histori', $user->id) }}" class="btn btn-sm btn-primary">
                                    Lihat Histori Moment
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">Belum ada pengguna Frontliner.</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
