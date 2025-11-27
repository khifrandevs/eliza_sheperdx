@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <section class="section-header bg-light">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-header d-flex justify-content-between align-items-center py-3">
                        <div class="header-title">
                            <h4 class="card-title mb-1 text-primary"><i class="mdi mdi-account-tie mr-2"></i>Detail Pendeta: {{ $pendeta->nama_pendeta }}</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('departemen.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('departemen.pendeta.index') }}">Data Pendeta</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                                </ol>
                            </nav>
                        </div>
                        <a href="{{ route('departemen.pendeta.index') }}" class="btn btn-outline-primary btn-icon-text">
                            <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-content py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-shadow">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="card-title mb-0 text-dark"><i class="mdi mdi-information-outline mr-2"></i>Informasi Pendeta</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="text-muted">ID Akun</span>
                                            <span class="font-weight-bold">{{ $pendeta->id_akun }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="text-muted">Nama Pendeta</span>
                                            <span class="font-weight-bold">{{ $pendeta->nama_pendeta }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="text-muted">No. Telp</span>
                                            <span class="font-weight-bold">{{ $pendeta->no_telp }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="text-muted">Region</span>
                                            <span class="font-weight-bold">{{ $pendeta->region->nama_region ?? '-' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="text-muted">Departemen</span>
                                            <span class="font-weight-bold">{{ $pendeta->departemen->nama_departemen ?? '-' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="text-muted">Gereja</span>
                                            <span class="font-weight-bold">{{ $pendeta->gereja->nama_gereja ?? '-' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="text-muted">Jabatan Aktif</span>
                                            <span class="font-weight-bold">
                                                {{ optional(optional($pendeta->jabatanHistories->first())->jabatan)->jabatan ?? '-' }}
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="text-muted">Alamat</span>
                                            <span class="font-weight-bold text-right">{{ $pendeta->alamat ?? '-' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card card-shadow">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="card-title mb-0 text-dark"><i class="mdi mdi-calendar-check mr-2"></i>Daftar Perlawatan</h5>
                        </div>
                        <div class="card-body">
                            @if($perlawatans->isEmpty())
                                <div class="alert alert-info">
                                    <i class="mdi mdi-information mr-2"></i>Tidak ada data perlawatan yang tersedia.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="thead-light">
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
                                                            <!-- Updated path for perlawatan images -->
                                                            <a href="{{ asset('gambar_bukti/' . basename($perlawatan->gambar_bukti)) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="mdi mdi-image mr-1"></i>Lihat
                                                            </a>
                                                        @else
                                                            <span class="badge badge-secondary">Tidak ada</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card card-shadow">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="card-title mb-0 text-dark"><i class="mdi mdi-calendar-clock mr-2"></i>Daftar Penjadwalan</h5>
                        </div>
                        <div class="card-body">
                            @if($penjadwalans->isEmpty())
                                <div class="alert alert-info">
                                    <i class="mdi mdi-information mr-2"></i>Tidak ada data penjadwalan yang tersedia.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="thead-light">
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
                                                    <td class="font-weight-bold">{{ $penjadwalan->judul_kegiatan }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($penjadwalan->tanggal_mulai)->format('d M Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($penjadwalan->tanggal_selesai)->format('d M Y') }}</td>
                                                    <td>{{ $penjadwalan->lokasi ?? '-' }}</td>
                                                    <td>{{ Str::limit($penjadwalan->deskripsi ?? '-', 50) }}</td>
                                                    <td>
                                                        @if ($penjadwalan->gambar_bukti)
                                                            <!-- Updated path for penjadwalan images -->
                                                            <a href="{{ asset('gambar_bukti_penjadwalan/' . basename($penjadwalan->gambar_bukti)) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="mdi mdi-image mr-1"></i>Lihat
                                                            </a>
                                                        @else
                                                            <span class="badge badge-secondary">Tidak ada</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card card-shadow">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="card-title mb-0 text-dark"><i class="mdi mdi-briefcase-clock mr-2"></i>Riwayat Jabatan</h5>
                        </div>
                        <div class="card-body">
                            @if($pendeta->jabatanHistories->isEmpty())
                                <div class="alert alert-info">
                                    <i class="mdi mdi-information mr-2"></i>Tidak ada riwayat jabatan.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Jabatan</th>
                                                <th>Gereja</th>
                                                <th>Tanggal Awal</th>
                                                <th>Tanggal Akhir</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pendeta->jabatanHistories as $history)
                                                <tr>
                                                    <td>{{ optional($history->jabatan)->jabatan ?? '-' }}</td>
                                                    <td>{{ optional($history->gereja)->nama_gereja ?? '-' }}</td>
                                                    <td>{{ optional($history->tanggal_awal)->format('d M Y') }}</td>
                                                    <td>{{ optional($history->tanggal_akhir)->format('d M Y') ?? '-' }}</td>
                                                    <td>
                                                        @if (is_null($history->tanggal_akhir))
                                                            <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            <span class="badge badge-secondary">Selesai</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card card-shadow">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="card-title mb-0 text-dark"><i class="mdi mdi-map-marker-radius mr-2"></i>Riwayat Region</h5>
                        </div>
                        <div class="card-body">
                            @if($pendeta->regionHistories->isEmpty())
                                <div class="alert alert-info">
                                    <i class="mdi mdi-information mr-2"></i>Tidak ada riwayat region.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Region</th>
                                                <th>Tanggal Awal</th>
                                                <th>Tanggal Akhir</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pendeta->regionHistories as $history)
                                                <tr>
                                                    <td>{{ optional($history->region)->nama_region ?? '-' }}</td>
                                                    <td>{{ optional($history->tanggal_awal)->format('d M Y') }}</td>
                                                    <td>{{ optional($history->tanggal_akhir)->format('d M Y') ?? '-' }}</td>
                                                    <td>
                                                        @if (is_null($history->tanggal_akhir))
                                                            <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            <span class="badge badge-secondary">Selesai</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .card-shadow {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: none;
        border-radius: 0.375rem;
    }
    .section-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e1e5eb;
    }
    .list-group-item {
        border-left: 0;
        border-right: 0;
        padding: 1rem 0;
    }
    .table th {
        border-top: 0;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .table td {
        vertical-align: middle;
    }
    .badge {
        font-weight: 500;
    }
</style>
@endsection
