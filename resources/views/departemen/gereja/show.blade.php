@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Detail Gereja</h4>
                            <p class="card-description mb-0">Informasi lengkap gereja dan pendeta yang ditugaskan</p>
                        </div>
                        <div>
                            <a href="{{ route('departemen.gereja.edit', $gereja) }}" class="btn btn-primary btn-icon-text me-2">
                                <i class="mdi mdi-pencil btn-icon-prepend"></i>
                                Edit
                            </a>
                            <a href="{{ route('departemen.gereja.index') }}" class="btn btn-light btn-icon-text">
                                <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
                                Kembali
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Informasi Gereja -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-church text-primary me-2"></i>
                                        Informasi Gereja
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Nama Gereja:</strong></td>
                                            <td>{{ $gereja->nama_gereja }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Region:</strong></td>
                                            <td>{{ $gereja->region->nama_region }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Alamat:</strong></td>
                                            <td>{{ $gereja->alamat ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Dibuat:</strong></td>
                                            <td>{{ $gereja->created_at->format('d M Y, H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Terakhir Diupdate:</strong></td>
                                            <td>{{ $gereja->updated_at->format('d M Y, H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Pendeta -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account-group text-success me-2"></i>
                                        Pendeta yang Ditugaskan
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @if($gereja->pendetas->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Pendeta</th>
                                                        <th>ID Akun</th>
                                                        <th>No. Telp</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($gereja->pendetas as $pendeta)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <i class="mdi mdi-account-circle text-success me-2"></i>
                                                                    <strong>{{ $pendeta->nama_pendeta }}</strong>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-info">{{ $pendeta->id_akun }}</span>
                                                            </td>
                                                            <td>{{ $pendeta->no_telp }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <i class="mdi mdi-information-outline me-1"></i>
                                                Total {{ $gereja->pendetas->count() }} pendeta ditugaskan ke gereja ini
                                            </small>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="mdi mdi-account-off text-muted" style="font-size: 48px;"></i>
                                            <h6 class="text-muted mt-3">Belum ada pendeta yang ditugaskan</h6>
                                            <p class="text-muted">Gereja ini belum memiliki pendeta yang ditugaskan.</p>
                                            <a href="{{ route('departemen.gereja.edit', $gereja) }}" class="btn btn-sm btn-primary">
                                                <i class="mdi mdi-plus me-1"></i>
                                                Edit Gereja
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Tambahan -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-chart-line text-info me-2"></i>
                                        Statistik Gereja
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <div class="border-end">
                                                <h4 class="text-primary">{{ $gereja->pendetas->count() }}</h4>
                                                <p class="text-muted mb-0">Jumlah Pendeta</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="border-end">
                                                <h4 class="text-success">{{ $gereja->anggotas->count() ?? 0 }}</h4>
                                                <p class="text-muted mb-0">Jumlah Anggota</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <h4 class="text-warning">{{ \Carbon\Carbon::parse($gereja->created_at)->diffInDays(now()) }}</h4>
                                                <p class="text-muted mb-0">Hari sejak dibuat</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
