@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Laporan Pendeta</h4>
                            <p class="card-description mb-0">Laporan aktivitas pendeta di region Anda - {{ Carbon\Carbon::now()->format('F Y') }}</p>
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
                                        <td>{{ $pendeta->no_telp ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $pendeta->jumlah_perlawatan }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $pendeta->jumlah_penjadwalan }}</span>
                                        </td>
                                        <td class="no-print">
                                            <a href="{{ route('departemen.laporan.export_excel', $pendeta->id) }}" class="btn btn-success btn-sm btn-icon-text">
                                                <i class="mdi mdi-file-excel btn-icon-prepend"></i>
                                                Excel
                                            </a>
                                            <a href="{{ route('departemen.laporan.export_pdf', $pendeta->id) }}" class="btn btn-danger btn-sm btn-icon-text">
                                                <i class="mdi mdi-file-pdf btn-icon-prepend"></i>
                                                PDF
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="py-4">
                                                <i class="mdi mdi-information-outline text-muted" style="font-size: 48px;"></i>
                                                <h6 class="text-muted mt-3">Tidak ada pendeta yang melakukan perlawatan bulan ini</h6>
                                                <p class="text-muted">Belum ada pendeta yang melakukan kunjungan pada bulan {{ Carbon\Carbon::now()->format('F Y') }}.</p>
                                            </div>
                                        </td>
                                    </tr>
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
        body * {
            visibility: hidden;
        }
        .content-wrapper, .content-wrapper * {
            visibility: visible;
        }
        .content-wrapper {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .btn, .breadcrumb, .alert, .no-print {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .table {
            border-collapse: collapse !important;
        }
        .table th, .table td {
            border: 1px solid #ddd !important;
            padding: 8px !important;
        }
        .table th {
            background-color: #f8f9fa !important;
        }
        h4, h5 {
            color: #000 !important;
        }
    }
</style>

<script>
    function printReport() {
        window.print();
    }
</script>
@endsection
