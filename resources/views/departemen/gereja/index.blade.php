@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Daftar Gereja</h4>
                            <p class="card-description mb-0">Daftar semua gereja di region Anda</p>
                        </div>
                        <a href="{{ route('departemen.gereja.create') }}" class="btn btn-primary btn-icon-text">
                            <i class="mdi mdi-plus-circle btn-icon-prepend"></i>
                            Tambah Gereja
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="gerejaTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Gereja</th>
                                    <th>Alamat</th>
                                    <th>Region</th>
                                    <th>Jumlah Pendeta</th>
                                    <th style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gerejas as $gereja)
                                    <tr>
                                        <td>{{ $gereja->nama_gereja }}</td>
                                        <td>{{ $gereja->alamat ?? '-' }}</td>
                                        <td>{{ $gereja->region->nama_region ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $gereja->pendetas->count() > 0 ? 'success' : 'warning' }}">
                                                {{ $gereja->pendetas->count() }} Pendeta
                                            </span>
                                            @if($gereja->pendetas->count() > 0)
                                                <br>
                                                <small class="text-muted">
                                                    @foreach($gereja->pendetas->take(2) as $pendeta)
                                                        {{ $pendeta->nama_pendeta }}@if(!$loop->last), @endif
                                                    @endforeach
                                                    @if($gereja->pendetas->count() > 2)
                                                        dan {{ $gereja->pendetas->count() - 2 }} lainnya
                                                    @endif
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center" style="gap: 8px;">
                                                <a href="{{ route('departemen.gereja.show', $gereja) }}" class="btn btn-sm btn-info btn-icon d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; padding: 0;" title="Lihat Detail">
                                                    <i class="mdi mdi-eye m-0" style="font-size: 16px; line-height: 1;"></i>
                                                </a>
                                                <a href="{{ route('departemen.gereja.edit', $gereja) }}" class="btn btn-sm btn-warning btn-icon d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; padding: 0;" title="Edit">
                                                    <i class="mdi mdi-pencil-box-outline m-0" style="font-size: 16px; line-height: 1;"></i>
                                                </a>
                                                <form action="{{ route('departemen.gereja.destroy', $gereja) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-icon d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; padding: 0;" title="Hapus" onclick="return confirm('Yakin ingin menghapus gereja ini?')">
                                                        <i class="mdi mdi-delete-outline m-0" style="font-size: 16px; line-height: 1;"></i>
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
        $('#gerejaTable').DataTable({
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
                { orderable: false, targets: 4 } // Menonaktifkan sorting untuk kolom aksi
            ],
            order: [[0, 'asc']] // Default sorting berdasarkan Nama Gereja
        });
    });
</script>
@endsection

<style>
    /* Penyesuaian styling untuk DataTables */
    #gerejaTable_wrapper .row:first-child {
        margin-bottom: 1rem;
    }

    #gerejaTable_filter input {
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
    #gerejaTable th:nth-child(5),
    #gerejaTable td:nth-child(5) {
        width: 150px !important;
        min-width: 150px !important;
        max-width: 150px !important;
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
