@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        <img class="img-fluid" src="{{ asset('assets/img/login.png') }}" alt="Logo" />
                    </div>
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>M-ESSENCE</h1>
                            <p class="account-subtitle">
                                Belum memiliki akun?
                                <a href="{{ route('register') }}">Daftar</a>
                            </p>
                            <h2>Masuk</h2>

                            {{-- Form login --}}
                            <form action="{{ route('login.post') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Username <span class="login-danger">*</span></label>
                                    <input class="form-control" type="text" name="username" value="{{ old('username') }}"
                                        required autofocus>
                                    <span class="profile-views"><i class="fas fa-user-circle"></i></span>
                                    @error('username')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Password <span class="login-danger">*</span></label>
                                    <input class="form-control pass-input" type="password" name="password" required>
                                    <span class="profile-views feather-eye toggle-password"></span>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Masuk</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Tambahkan toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}", "Berhasil", {
                timeOut: 5000,
                progressBar: true
            });
        @endif

        @if ($errors->any())
            toastr.error("{{ $errors->first() }}", "Gagal", {
                timeOut: 5000,
                progressBar: true
            });
        @endif
    </script>
@endsection
