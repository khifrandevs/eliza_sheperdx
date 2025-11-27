@extends('superadmin.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Daftar Region</h4>
                            <p class="card-description mb-0">Daftar semua region yang terdaftar</p>
                        </div>
                        <a href="{{ route('superadmin.region.create') }}" class="btn btn-primary btn-icon-text">
                            <i class="mdi mdi-plus-circle btn-icon-prepend"></i>
                            Tambah Region
                        </a>
                    </div>
                    
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table id="regionTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kode Region</th>
                                    <th>Nama Region</th>
                                    <th>Deskripsi</th>
                                    <th style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($regions as $region)
                                    <tr>
                                        <td>{{ $region->kode_region }}</td>
                                        <td>{{ $region->nama_region }}</td>
                                        <td>{{ $region->deskripsi ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center" style="gap: 10px;">
                                                <a href="{{ route('superadmin.region.edit', $region) }}" class="btn btn-sm btn-warning btn-icon d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; padding: 0;" title="Edit">
                                                    <i class="mdi mdi-pencil-box-outline m-0" style="font-size: 18px; line-height: 1;"></i>
                                                </a>
                                                <form action="{{ route('superadmin.region.destroy', $region) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-icon d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; padding: 0;" title="Hapus" onclick="return confirm('Yakin ingin menghapus region ini?')">
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

<!-- Menambahkan CSS DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<!-- Menambahkan JavaScript DataTables -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#regionTable').DataTable({
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
                { orderable: false, targets: 3 } // Menonaktifkan sorting untuk kolom aksi
            ]
        });
    });
</script>

<style>
    /* Penyesuaian styling untuk DataTables */
    #regionTable_wrapper .row:first-child {
        margin-bottom: 1rem;
    }
    
    #regionTable_filter input {
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
    #regionTable th:nth-child(4),
    #regionTable td:nth-child(4) {
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