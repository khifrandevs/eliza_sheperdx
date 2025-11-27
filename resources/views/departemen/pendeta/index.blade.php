@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Daftar Pendeta</h4>
                            <p class="card-description mb-0">Daftar semua pendeta di region Anda</p>
                        </div>
                        <a href="{{ route('departemen.pendeta.create') }}" class="btn btn-primary btn-icon-text">
                            <i class="mdi mdi-plus-circle btn-icon-prepend"></i>
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
                                    <th>Nama Pendeta</th>
                                    <th>No. Telp</th>
                                    <th>Alamat</th>
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
                                        <td>{{ $pendeta->no_telp }}</td>
                                        <td>{{ $pendeta->alamat ?? '-' }}</td>
                                        <td>{{ $pendeta->departemen->nama_departemen ?? '-' }}</td>
                                        <td>{{ $pendeta->gereja->nama_gereja ?? '-' }}</td>
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
                                                <a href="{{ route('departemen.pendeta.detail', $pendeta) }}" class="btn btn-sm btn-info btn-icon d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; padding: 0;" title="Detail">
                                                    <i class="mdi mdi-eye m-0" style="font-size: 18px; line-height: 1;"></i>
                                                </a>
                                                <a href="{{ route('departemen.pendeta.edit', $pendeta) }}" class="btn btn-sm btn-warning btn-icon d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; padding: 0;" title="Edit">
                                                    <i class="mdi mdi-pencil-box-outline m-0" style="font-size: 18px; line-height: 1;"></i>
                                                </a>
                                                <form action="{{ route('departemen.pendeta.destroy', $pendeta) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-icon d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; padding: 0;" title="Hapus" onclick="return confirm('Yakin ingin menghapus pendeta ini?')">
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
                { orderable: false, targets: 8 }
            ],
            order: [[0, 'asc']]
        });

        $('#filterJabatan').on('change', function() {
            const val = $(this).val();
            dt.column(6).search(val).draw();
        });

        // Optional filters: Departemen & Gereja
        const filterDepartemen = $('<select class="form-select" id="filterDepartemen"><option value>Semua Departemen</option>@php $depts = $pendetas->pluck('departemen.nama_departemen')->filter()->unique()->sort(); @endphp @foreach($depts as $d)<option value="{{ $d }}">{{ $d }}</option>@endforeach</select>');
        const filterGereja = $('<select class="form-select" id="filterGereja"><option value>Semua Gereja</option>@php $gerejas = $pendetas->pluck('gereja.nama_gereja')->filter()->unique()->sort(); @endphp @foreach($gerejas as $g)<option value="{{ $g }}">{{ $g }}</option>@endforeach</select>');
        $('#filterJabatan').closest('.row').append($('<div class="col-md-4"><label class="form-label">Filter Departemen</label></div>').append(filterDepartemen));
        $('#filterJabatan').closest('.row').append($('<div class="col-md-4"><label class="form-label">Filter Gereja</label></div>').append(filterGereja));
        $('#filterDepartemen').on('change', function(){ dt.column(4).search($(this).val()).draw(); });
        $('#filterGereja').on('change', function(){ dt.column(5).search($(this).val()).draw(); });
    });
</script>
@endsection

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
    #pendetaTable th:nth-child(8),
    #pendetaTable td:nth-child(8) {
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
