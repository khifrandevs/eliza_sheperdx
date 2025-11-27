@extends('superadmin.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Laporan Pendeta</h4>
                            <p class="card-description mb-0">Laporan aktivitas pendeta - {{ Carbon\Carbon::now()->format('F Y') }}</p>
                        </div>
                        <div>
                            <button onclick="window.print()" class="btn btn-primary btn-icon-text">
                                <i class="mdi mdi-printer btn-icon-prepend"></i>
                                Print
                            </button>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Akun</th>
                                    <th>Nama Pendeta</th>
                                    <th>Region</th>
                                    <th>Departemen</th>
                                    <th>No Telepon</th>
                                    <th>Jumlah Perlawatan</th>
                                    <th>Jumlah Penjadwalan</th>
                                    <th class="no-print">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendetas as $index => $pendeta)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $pendeta->id_akun }}</td>
                                        <td>{{ $pendeta->nama_pendeta }}</td>
                                        <td>{{ $pendeta->region->nama_region ?? '-' }}</td>
                                        <td>{{ $pendeta->departemen->nama_departemen ?? '-' }}</td>
                                        <td>{{ $pendeta->no_telp ?? '-' }}</td>
                                        <td><span class="badge badge-info">{{ $pendeta->jumlah_perlawatan }}</span></td>
                                        <td><span class="badge badge-secondary">{{ $pendeta->jumlah_penjadwalan }}</span></td>
                                        <td class="no-print">
                                            <a href="{{ route('superadmin.laporan.export_excel', $pendeta->id) }}" class="btn btn-success btn-sm btn-icon-text">
                                                <i class="mdi mdi-file-excel btn-icon-prepend"></i>
                                                Excel
                                            </a>
                                            <a href="{{ route('superadmin.laporan.export_pdf', $pendeta->id) }}" class="btn btn-danger btn-sm btn-icon-text">
                                                <i class="mdi mdi-file-pdf btn-icon-prepend"></i>
                                                PDF
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="9" class="text-center">Tidak ada pendeta yang melakukan perlawatan bulan ini</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        .content-wrapper, .content-wrapper * { visibility: visible; }
        .content-wrapper { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 20px; }
        .btn, .breadcrumb, .alert, .no-print { display: none !important; }
        .card { border: none !important; box-shadow: none !important; margin: 0; }
        .table { border-collapse: collapse !important; width: 100%; font-size: 12px; }
        .table th, .table td { border: 1px solid #ddd !important; padding: 6px !important; }
        .table th { background-color: #f8f9fa !important; }
        h4, h5 { color: #000 !important; margin: 0 0 10px 0; }
        .table-responsive { overflow: visible !important; }
    }
</style>
@endsection
