@extends('layouts.app')

@section('title', 'Histori Moment')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Histori Moment</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Histori Moment</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row align-items-center mb-3">
            <div class="col-md-12 text-end">
                <a href="{{ route('rekapmoment.export') }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Ekspor ke Excel
                </a>
            </div>
        </div>

        <div class="row mb-5">
            @forelse($moments as $moment)
                <div class="col-md-4 mb-3">
                    <div class="card mb-3 h-100 moment-card" style="cursor:pointer;" data-bs-toggle="modal"
                        data-bs-target="#momentModal" data-nm_nasabah="{{ $moment->nm_nasabah }}"
                        data-cif="{{ $moment->cif }}"
                        data-tgl_lahir="{{ \Carbon\Carbon::parse($moment->tgl_lahir)->format('d M Y') }}"
                        data-no_hp="{{ $moment->no_hp }}" data-moments="{{ $moment->moments }}"
                        data-deskripsi="{{ $moment->deskripsi ?? '-' }}"
                        data-foto_moment="{{ $moment->foto_moment ? asset('storage/moment/' . $moment->foto_moment) : '' }}"
                        data-user_foto="{{ $moment->user->detail->foto_url ?? asset('assets/img/profiles/user.png') }}"
                        data-user_nama="{{ $moment->user->detail->nama ?? $moment->user->username }}"
                        data-created_at="{{ $moment->created_at->format('d M Y H:i') }}">
                        <div class="card-header d-flex align-items-center">
                            <img src="{{ $moment->user->detail->foto_url ?? asset('assets/img/profiles/user.png') }}"
                                alt="{{ $moment->user->username }}" class="rounded-circle" width="40" height="40">
                            <div class="ms-2">
                                <small class="text-muted">Diinput: {{ $moment->user->detail->nama }} pada
                                    {{ $moment->created_at->format('d M Y H:i') }}</small>
                            </div>
                        </div>
                        @if ($moment->foto_moment)
                            <img src="{{ asset('storage/moment/' . $moment->foto_moment) }}" class="card-img-top"
                                alt="Foto Moment">
                        @endif
                        <div class="card-body">
                            <p class="card-text">{{ Str::limit($moment->deskripsi ?? '-', 100) }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">Belum ada histori moment.</div>
                </div>
            @endforelse
        </div>

        <!-- Modal Dinamis -->
        <div class="modal fade" id="momentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Moment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <img id="modalFotoMoment" src="" class="img-fluid rounded" alt="Foto Moment">
                        </div>
                        <p><strong>Nama Nasabah:</strong> <span id="modalNmNasabah"></span></p>
                        <p><strong>CIF:</strong> <span id="modalCIF"></span></p>
                        <p><strong>Tanggal Lahir:</strong> <span id="modalTglLahir"></span></p>
                        <p><strong>No HP:</strong> <span id="modalNoHP"></span></p>
                        <p><strong>Moments:</strong> <span id="modalMoments"></span></p>
                        <p><strong>Deskripsi:</strong> <span id="modalDeskripsi"></span></p>
                        <p><strong>Diinput oleh:</strong> <span id="modalUserNama"></span></p>
                        <p><strong>Waktu Input:</strong> <span id="modalCreatedAt"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Script untuk isi modal dinamis -->
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const momentModal = document.getElementById('momentModal');

            momentModal.addEventListener('show.bs.modal', function(event) {
                const card = event.relatedTarget;

                document.getElementById('modalFotoMoment').src = card.dataset.foto_moment || '';
                document.getElementById('modalNmNasabah').textContent = card.dataset.nm_nasabah;
                document.getElementById('modalCIF').textContent = card.dataset.cif;
                document.getElementById('modalTglLahir').textContent = card.dataset.tgl_lahir;
                document.getElementById('modalNoHP').textContent = card.dataset.no_hp;
                document.getElementById('modalMoments').textContent = card.dataset.moments;
                document.getElementById('modalDeskripsi').textContent = card.dataset.deskripsi;
                document.getElementById('modalUserNama').textContent = card.dataset.user_nama;
                document.getElementById('modalCreatedAt').textContent = card.dataset.created_at;
            });
        });
    </script>
@endsection
