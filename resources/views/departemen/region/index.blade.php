@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Daftar Region</h4>
                            <p class="card-description mb-0">Daftar region Anda</p>
                        </div>
                        <a href="{{ route('departemen.region.create') }}" class="btn btn-primary btn-icon-text">
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
                        <table class="table table-striped">
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
                                                <a href="{{ route('departemen.region.edit', $region) }}" class="btn btn-sm btn-warning btn-icon rounded d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="Edit">
                                                    <i class="mdi mdi-pencil-box-outline" style="font-size: 18px; line-height: 1;"></i>
                                                </a>
                                                <form action="{{ route('departemen.region.destroy', $region) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-icon rounded d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="Hapus" onclick="return confirm('Yakin ingin menghapus region ini?')">
                                                        <i class="mdi mdi-delete-outline" style="font-size: 18px; line-height: 1;"></i>
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
@endsection