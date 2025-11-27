@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Daftar Anggota</h4>
                            <p class="card-description mb-0">Daftar semua anggota di region Anda</p>
                        </div>
                        <a href="{{ route('departemen.anggota.create') }}" class="btn btn-primary btn-icon-text">
                            <i class="mdi mdi-plus-circle btn-icon-prepend"></i>
                            Tambah Anggota
                        </a>
                    </div>
                    
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table id="anggotaTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Anggota</th>
                                    <th>No. Telp</th>
                                    <th>Alamat</th>
                                    <th>Gereja</th>
                                    <th>Dibuat</th>
                                    <th>Diperbarui</th>
                                    <th style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($anggotas as $anggota)
                                    <tr>
                                        <td>{{ $anggota->nama_anggota }}</td>
                                        <td>{{ $anggota->no_telp ?? '-' }}</td>
                                        <td>{{ $anggota->alamat ?? '-' }}</td>
                                        <td>{{ $anggota->gereja->nama_gereja ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($anggota->created_at)->format('d M Y H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($anggota->updated_at)->format('d M Y H:i') }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center" style="gap: 10px;">
                                                <a href="{{ route('departemen.anggota.edit', $anggota) }}" class="btn btn-sm btn-warning btn-icon d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; padding: 0;" title="Edit">
                                                    <i class="mdi mdi-pencil-box-outline m-0" style="font-size: 18px; line-height: 1;"></i>
                                                </a>
                                                <form action="{{ route('departemen.anggota.destroy', $anggota) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-icon d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; padding: 0;" title="Hapus" onclick="return confirm('Yakin ingin menghapus anggota ini?')">
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
        $('#anggotaTable').DataTable({
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
            order: [[0, 'asc']] // Default sorting berdasarkan Nama Anggota
        });
    });
</script>
@endsection

<style>
    /* Penyesuaian styling untuk DataTables */
    #anggotaTable_wrapper .row:first-child {
        margin-bottom: 1rem;
    }
    
    #anggotaTable_filter input {
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
    #anggotaTable th:nth-child(7),
    #anggotaTable td:nth-child(7) {
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
</style>
@endsection