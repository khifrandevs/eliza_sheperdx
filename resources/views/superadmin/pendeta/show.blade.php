@extends('superadmin.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Detail Pendeta: {{ $pendeta->nama_pendeta }}</h4>
                            <p class="card-description mb-0">Informasi pendeta dan riwayat region</p>
                        </div>
                        <a href="{{ route('superadmin.pendeta.index') }}" class="btn btn-light btn-icon-text">
                            <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
                            Kembali
                        </a>
                    </div>

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
                                    <span class="text-muted">Alamat</span>
                                    <span class="font-weight-bold text-right">{{ $pendeta->alamat ?? '-' }}</span>
                                </li>
                            </ul>
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
            </div>
        </div>
    </div>
</div>

<style>
    .card-shadow { box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: none; border-radius: 0.375rem; }
    .list-group-item { border-left: 0; border-right: 0; padding: 1rem 0; }
    .table th { border-top: 0; font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; }
    .table td { vertical-align: middle; }
    .badge { font-weight: 500; }
</style>
@endsection
