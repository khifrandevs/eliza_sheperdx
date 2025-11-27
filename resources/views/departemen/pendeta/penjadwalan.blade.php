@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <section class="section-header">
        <div class="row">
            <div class="col-12">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4 class="card-title mb-1">Penjadwalan Pendeta: {{ $pendeta->nama_pendeta }}</h4>
                        <p class="card-description mb-0 text-muted">Daftar jadwal kegiatan pendeta</p>
                    </div>
                    <a href="{{ route('departemen.pendeta.index') }}" class="btn btn-light btn-icon-text">
                        <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Daftar Penjadwalan</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Judul Kegiatan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Lokasi</th>
                                        <th>Deskripsi</th>
                                        <th>Gambar Bukti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjadwalans as $penjadwalan)
                                        <tr>
                                            <td>{{ $penjadwalan->judul_kegiatan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($penjadwalan->tanggal_mulai)->format('d M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($penjadwalan->tanggal_selesai)->format('d M Y') }}</td>
                                            <td>{{ $penjadwalan->lokasi ?? '-' }}</td>
                                            <td>{{ $penjadwalan->deskripsi ?? '-' }}</td>
                                            <td>
                                                @if ($penjadwalan->gambar_bukti)
                                                    <a href="{{ asset('storage/' . $penjadwalan->gambar_bukti) }}" target="_blank">Lihat Gambar</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection