@extends('superadmin.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Daftar Pendeta</h4>
                            <p class="card-description mb-0">Daftar semua pendeta yang terdaftar</p>
                        </div>
                        <a href="{{ route('superadmin.pendeta.create') }}" class="btn btn-primary btn-icon-text">
                            <i class="mdi mdi-account-plus btn-icon-prepend"></i>
                            Tambah Pendeta
                        </a>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Filter Jabatan</label>
                            <select id="filterJabatan" class="form-select">
                                <option value="">Semua</option>
                                @php
                                    $jabatans = $pendetas->pluck('jabatanHistories')->flatten()->pluck('jabatan.jabatan')->filter()->unique()->sort();
                                @endphp
                                @foreach ($jabatans as $j)
                                    <option value="{{ $j }}">{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="pendetaTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID Akun</th>
                                    <th>Nama</th>
                                    <th>Region</th>
                                    <th>Departemen</th>
                                    <th>Gereja</th>
                                    <th>Jabatan</th>
                                    <th>Mulai Jabatan</th>
                                    <th style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendetas as $pendeta)
                                    <tr>
                                        <td>{{ $pendeta->id_akun }}</td>
                                        <td>{{ $pendeta->nama_pendeta }}</td>
                                        <td>{{ $pendeta->region ? $pendeta->region->nama_region : '-' }}</td>
                                        <td>{{ $pendeta->departemen ? $pendeta->departemen->nama_departemen : '-' }}</td>
                                        <td>{{ $pendeta->gereja ? $pendeta->gereja->nama_gereja : '-' }}</td>
                                        <td>
                                            @php
                                                $jabatanNama = optional(optional($pendeta->jabatanHistories->first())->jabatan)->jabatan;
                                                $badgeClass = 'badge-secondary';
                                                if ($jabatanNama === 'Gembala Jemaat') $badgeClass = 'badge-primary';
                                                elseif ($jabatanNama === 'Direktur Kependetaan Departemen') $badgeClass = 'badge-warning';
                                            @endphp
                                            @if ($jabatanNama)
                                                <span class="badge {{ $badgeClass }}">{{ $jabatanNama }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @php $mulai = optional(optional($pendeta->jabatanHistories->first())->tanggal_awal); @endphp
                                            {{ $mulai ? $mulai->format('d M Y') : '-' }}
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center" style="gap: 10px;">
                                                <a href="{{ route('superadmin.pendeta.show', $pendeta) }}" class="btn btn-sm btn-info btn-icon d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; padding: 0;" title="Detail">
                                                    <i class="mdi mdi-eye m-0" style="font-size: 18px; line-height: 1;"></i>
                                                </a>
                                                <a href="{{ route('superadmin.pendeta.edit', $pendeta) }}" class="btn btn-sm btn-warning btn-icon d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; padding: 0;" title="Edit">
                                                    <i class="mdi mdi-pencil-box-outline m-0" style="font-size: 18px; line-height: 1;"></i>
                                                </a>
                                                <form action="{{ route('superadmin.pendeta.destroy', $pendeta) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-icon d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; padding: 0;" title="Hapus" onclick="return confirm('Yakin ingin menghapus pendeta ini?')">
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
        const dt = $('#pendetaTable').DataTable({
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
                { orderable: false, targets: 7 }
            ],
            order: [[0, 'asc']]
        });

        $('#filterJabatan').on('change', function() {
            const val = $(this).val();
            dt.column(5).search(val).draw();
        });

        // Optional filters: Region & Gereja
        const filterRegion = $('<select class="form-select" id="filterRegion"><option value>Semua Region</option>@php $regions = $pendetas->pluck('region.nama_region')->filter()->unique()->sort(); @endphp @foreach($regions as $r)<option value="{{ $r }}">{{ $r }}</option>@endforeach</select>');
        const filterGereja = $('<select class="form-select" id="filterGereja"><option value>Semua Gereja</option>@php $gerejas = $pendetas->pluck('gereja.nama_gereja')->filter()->unique()->sort(); @endphp @foreach($gerejas as $g)<option value="{{ $g }}">{{ $g }}</option>@endforeach</select>');
        $('#filterJabatan').closest('.row').append($('<div class="col-md-4"><label class="form-label">Filter Region</label></div>').append(filterRegion));
        $('#filterJabatan').closest('.row').append($('<div class="col-md-4"><label class="form-label">Filter Gereja</label></div>').append(filterGereja));
        $('#filterRegion').on('change', function(){ dt.column(2).search($(this).val()).draw(); });
        $('#filterGereja').on('change', function(){ dt.column(4).search($(this).val()).draw(); });
    });
    });
</script>

<style>
    /* Penyesuaian styling untuk DataTables */
    #pendetaTable_wrapper .row:first-child {
        margin-bottom: 1rem;
    }

    #pendetaTable_filter input {
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
    #pendetaTable th:nth-child(7),
    #pendetaTable td:nth-child(7) {
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
