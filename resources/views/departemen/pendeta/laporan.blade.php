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
                            <p class="card-description mb-0">Laporan data pendeta berdasarkan filter bulan dan tahun</p>
                        </div>
                        <div>
                            <a href="{{ route('departemen.pendeta.export.excel', ['month' => $month, 'year' => $year]) }}" class="btn btn-success btn-icon-text">
                                <i class="mdi mdi-file-excel btn-icon-prepend"></i>
                                Export Excel
                            </a>
                            <a href="{{ route('departemen.pendeta.export.pdf', ['month' => $month, 'year' => $year]) }}" class="btn btn-danger btn-icon-text">
                                <i class="mdi mdi-file-pdf btn-icon-prepend"></i>
                                Export PDF
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('departemen.pendeta.laporan') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="month">Bulan</label>
                                    <select name="month" id="month" class="form-control">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="year">Tahun</label>
                                    <select name="year" id="year" class="form-control">
                                        @foreach ($years as $y)
                                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 align-self-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table id="pendetaTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID Akun</th>
                                    <th>Nama Pendeta</th>
                                    <th>No. Telp</th>
                                    <th>Alamat</th>
                                    <th>Region</th>
                                    <th>Departemen</th>
                                    <th>Gereja</th>
                                    <th>Jumlah Perlawatan</th>
                                    <th>Jumlah Penjadwalan</th>
                                    <th>Dibuat</th>
                                    <th>Diperbarui</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendetas as $pendeta)
                                    <tr>
                                        <td>{{ $pendeta->id_akun }}</td>
                                        <td>{{ $pendeta->nama_pendeta }}</td>
                                        <td>{{ $pendeta->no_telp ?? '-' }}</td>
                                        <td>{{ $pendeta->alamat ?? '-' }}</td>
                                        <td>{{ $pendeta->region->nama_region ?? '-' }}</td>
                                        <td>{{ $pendeta->departemen->nama_departemen ?? '-' }}</td>
                                        <td>{{ $pendeta->gereja->nama_gereja ?? '-' }}</td>
                                        <td>{{ $pendeta->perlawatans->count() }}</td>
                                        <td>{{ $pendeta->penjadwalans->count() }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pendeta->created_at)->format('d M Y H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pendeta->updated_at)->format('d M Y H:i') }}</td>
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
        $('#pendetaTable').DataTable({
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
            order: [[1, 'asc']] // Default sorting berdasarkan Nama Pendeta
        });
    });
</script>
@endsection

<style>
    #pendetaTable_wrapper .row:first-child {
        margin-bottom: 1rem;
    }
    
    #pendetaTable_filter input {
        border-radius: 4px;
        padding: 5px 10px;
        border: 1px solid #ccc;
    }
    
    .dataTables_info {
        padding-top: 0.755em !important;
    }
    
    .page-item.active .page-link {
        background-color: #5e72e4;
        border-color: #5e72e4;
    }
</style>
@endsection