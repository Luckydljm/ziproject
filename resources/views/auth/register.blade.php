@extends('layouts.auth')

@section('title', 'Daftar')

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
                            <h1>Registrasi Akun</h1>
                            <p class="account-subtitle">Isi form berikut untuk membuat akun baru</p>

                            {{-- Tampilkan error validasi --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Form Registrasi --}}
                            <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- Username --}}
                                <div class="form-group">
                                    <label>Username <span class="login-danger">*</span></label>
                                    <input name="username" class="form-control" type="text" value="{{ old('username') }}"
                                        required />
                                    <span class="profile-views"><i class="fas fa-user-circle"></i></span>
                                </div>

                                {{-- Password --}}
                                <div class="form-group">
                                    <label>Password <span class="login-danger">*</span></label>
                                    <input name="password" class="form-control pass-input" type="password" required />
                                    <span class="profile-views feather-eye toggle-password"></span>
                                </div>

                                {{-- Role --}}
                                <div class="form-group">
                                    <label>Role <span class="login-danger">*</span></label>
                                    <select name="role" class="form-control" required>
                                        <option value="">-- Pilih Role --</option>
                                        <option value="Frontliner" {{ old('role') == 'Frontliner' ? 'selected' : '' }}>
                                            Frontliner</option>
                                        <option value="Kepala Cabang"
                                            {{ old('role') == 'Kepala Cabang' ? 'selected' : '' }}>Kepala Cabang</option>
                                    </select>
                                </div>

                                {{-- Nama --}}
                                <div class="form-group">
                                    <label>Nama <span class="login-danger">*</span></label>
                                    <input name="nama" class="form-control" type="text" value="{{ old('nama') }}"
                                        required />
                                </div>

                                {{-- NIP --}}
                                <div class="form-group">
                                    <label>NIP <span class="login-danger">*</span></label>
                                    <input name="nip" class="form-control" type="text" value="{{ old('nip') }}"
                                        required />
                                </div>

                                {{-- Unit Kerja --}}
                                <div class="form-group">
                                    <label>Unit Kerja <span class="login-danger">*</span></label>
                                    <input name="unit_kerja" class="form-control" type="text"
                                        value="{{ old('unit_kerja') }}" required />
                                </div>

                                {{-- Jabatan --}}
                                <div class="form-group">
                                    <label>Jabatan <span class="login-danger">*</span></label>
                                    <input name="jabatan" class="form-control" type="text" value="{{ old('jabatan') }}"
                                        required />
                                </div>

                                {{-- Foto Profil --}}
                                <div class="form-group">
                                    <label>Foto Profil <span class="login-danger">*</span></label><br>
                                    <input type="file" name="foto" class="form-control" accept="image/*" />
                                    <small class="text-muted">Format: JPG, PNG. Maksimal ukuran 1MB.</small>
                                </div>

                                <div class="dont-have">
                                    Sudah punya akun? <a href="{{ route('login') }}">Login</a>
                                </div>

                                <div class="form-group mb-0">
                                    <button class="btn btn-primary btn-block" type="submit">Daftar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
