@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Daftar Permohonan Perpindahan</h4>
                            <p class="card-description mb-0">Daftar permohonan perpindahan pendeta di region Anda</p>
                        </div>
                        <a href="{{ route('departemen.permohonan_perpindahan.create') }}" class="btn btn-primary btn-icon-text">
                            <i class="mdi mdi-plus-circle btn-icon-prepend"></i>
                            Tambah Permohonan
                        </a>
                    </div>
                    
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table id="permohonanTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Pendeta</th>
                                    <th>Region Asal</th>
                                    <th>Region Tujuan</th>
                                    <th>Alasan</th>
                                    <th>Status</th>
                                    <th>Tanggal Permohonan</th>
                                    <th style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permohonans as $permohonan)
                                    <tr>
                                        <td>{{ $permohonan->pendeta->nama_pendeta ?? '-' }}</td>
                                        <td>{{ $permohonan->regionAsal->nama_region ?? '-' }}</td>
                                        <td>{{ $permohonan->regionTujuan->nama_region ?? '-' }}</td>
                                        <td>{{ Str::limit($permohonan->alasan ?? '-', 50) }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($permohonan->status == 'disetujui') badge-success 
                                                @elseif($permohonan->status == 'ditolak') badge-danger 
                                                @elseif($permohonan->status == 'diproses') badge-warning 
                                                @else badge-secondary @endif">
                                                {{ $permohonan->status }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->format('d M Y') }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center" style="gap: 10px;">
                                                <a href="{{ route('departemen.permohonan_perpindahan.edit', $permohonan) }}" class="btn btn-sm btn-warning btn-icon d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; padding: 0;" title="Edit">
                                                    <i class="mdi mdi-pencil-box-outline m-0" style="font-size: 18px; line-height: 1;"></i>
                                                </a>
                                                <form action="{{ route('departemen.permohonan_perpindahan.destroy', $permohonan) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-icon d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; padding: 0;" title="Hapus" onclick="return confirm('Yakin ingin menghapus permohonan ini?')">
                                                        <i class="mdi mdi-delete-outline m-0" style="font-size: 18px; line-height: 1;"></i>
                                                    </button>
                                                </form>
                                            </div>
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
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        $('#permohonanTable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ada data yang ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            columnDefs: [
                { orderable: false, targets: 6 } // Menonaktifkan sorting untuk kolom aksi
            ],
            order: [[5, 'desc']] // Default sorting berdasarkan Tanggal Permohonan (terbaru)
        });
    });
</script>
@endsection

<style>
    /* Penyesuaian styling untuk DataTables */
    #permohonanTable_wrapper .row:first-child {
        margin-bottom: 1rem;
    }
    
    #permohonanTable_filter input {
        border-radius: 4px;
        padding: 5px 10px;
        border: 1px solid #ccc;
    }
    
    /* Memastikan tampilan tetap sesuai dengan tema */
    .dataTables_info {
        padding-top: 0.755em !important;
    }
    
    .page-item.active .page-link {
        background-color: #5e72e4;
        border-color: #5e72e4;
    }
    
    /* Memastikan kolom aksi tetap pada ukuran yang tepat */
    #permohonanTable th:nth-child(7),
    #permohonanTable td:nth-child(7) {
        width: 120px !important;
        min-width: 120px !important;
        max-width: 120px !important;
        text-align: center;
    }
    
    /* Perbaikan posisi icon di dalam tombol */
    .btn-icon {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 !important;
    }
    
    .btn-icon i {
        margin: 0 !important;
        line-height: 1 !important;
    }
    
    /* Style untuk badge status */
    .badge-success {
        background-color: #28a745;
        color: white;
    }
    
    .badge-danger {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
    
    .badge-secondary {
        background-color: #6c757d;
        color: white;
    }
</style>
@endsection