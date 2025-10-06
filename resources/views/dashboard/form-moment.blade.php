@extends('layouts.app')

@section('title', 'Input Nasabah')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Input Nasabah</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Input Nasabah</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('moment.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title"><span>Moment Nasabah</span></h5>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Nama Nasabah <span class="login-danger">*</span></label>
                                        <input type="text" name="nm_nasabah" class="form-control"
                                            value="{{ old('nm_nasabah') }}" required />
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>CIF <span class="login-danger">*</span></label>
                                        <input type="number" name="cif" class="form-control"
                                            value="{{ old('cif') }}" required />
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms calendar-icon">
                                        <label>Tanggal Lahir <span class="login-danger">*</span></label>
                                        <input type="text" name="tgl_lahir" class="form-control datetimepicker"
                                            value="{{ old('tgl_lahir') }}" placeholder="DD-MM-YYYY" required />
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group local-forms">
                                        <label>No HP <span class="login-danger">*</span></label>
                                        <input type="text" name="no_hp" class="form-control"
                                            value="{{ old('no_hp') }}" required />
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group local-forms">
                                        <label>Moments <span class="login-danger">*</span></label>
                                        <select id="momentSelect" name="moments" class="form-control" required>
                                            <option value="">-- Pilih Moment --</option>
                                            <option value="Empowered Care Moment"
                                                {{ old('moments') == 'Empowered Care Moment' ? 'selected' : '' }}>
                                                Empowered Care Moment
                                            </option>
                                            <option value="Special Day Moment"
                                                {{ old('moments') == 'Special Day Moment' ? 'selected' : '' }}>
                                                Special Day Moment
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group local-forms">
                                        <label>Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12">
                                    <div class="form-group local-forms">
                                        <label>Foto Moment</label><br>
                                        <input type="file" name="foto_moment" class="form-control" accept="image/*" />
                                    </div>
                                </div>

                                {{-- Bagian tanggal mulai & selesai --}}
                                <div id="tanggalFields">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group local-forms calendar-icon">
                                                <label>Tanggal Mulai</label>
                                                <input type="text" name="tgl_mulai" class="form-control datetimepicker"
                                                    value="{{ old('tgl_mulai') }}" placeholder="DD-MM-YYYY" />
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group local-forms calendar-icon">
                                                <label>Tanggal Selesai</label>
                                                <input type="text" name="tgl_selesai" class="form-control datetimepicker"
                                                    value="{{ old('tgl_selesai') }}" placeholder="DD-MM-YYYY" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="student-submit">
                                        <button type="submit" class="btn btn-primary">Simpan Moment</button>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- 🧠 Tambahkan script berikut --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const momentSelect = document.getElementById('momentSelect');
            const tanggalFields = document.getElementById('tanggalFields');

            function toggleTanggalFields() {
                if (momentSelect.value === 'Special Day Moment') {
                    tanggalFields.style.display = 'none';
                    tanggalFields.querySelectorAll('input').forEach(input => {
                        input.value = '';
                        input.removeAttribute('required');
                    });
                } else {
                    tanggalFields.style.display = 'block';
                    tanggalFields.querySelectorAll('input').forEach(input => {
                        input.setAttribute('required', true);
                    });
                }
            }

            // Jalankan saat pertama kali load (agar konsisten dengan old value)
            toggleTanggalFields();

            // Jalankan setiap kali user mengganti moment
            momentSelect.addEventListener('change', toggleTanggalFields);
        });
    </script>
@endsection
