@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <section class="section-header">
        <div class="row">
            <div class="col-12">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4 class="card-title mb-1">Perlawatan Pendeta: {{ $pendeta->nama_pendeta }}</h4>
                        <p class="card-description mb-0 text-muted">Daftar perlawatan pendeta</p>
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
                        <h5 class="card-title mb-4">Daftar Perlawatan</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Anggota</th>
                                        <th>Tanggal</th>
                                        <th>Lokasi</th>
                                        <th>Catatan</th>
                                        <th>Gambar Bukti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perlawatans as $perlawatan)
                                        <tr>
                                            <td>{{ $perlawatan->anggota->nama_anggota ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($perlawatan->tanggal)->format('d M Y') }}</td>
                                            <td>{{ $perlawatan->lokasi }}</td>
                                            <td>{{ $perlawatan->catatan ?? '-' }}</td>
                                            <td>
                                                @if ($perlawatan->gambar_bukti)
                                                    <a href="{{ asset('storage/' . $perlawatan->gambar_bukti) }}" target="_blank">Lihat Gambar</a>
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