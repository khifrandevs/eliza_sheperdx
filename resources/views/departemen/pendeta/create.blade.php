@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <section class="section-header bg-light">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-header d-flex justify-content-between align-items-center py-3">
                        <div class="header-title">
                            <h4 class="card-title mb-1 text-primary"><i class="mdi mdi-account-plus mr-2"></i>Tambah Pendeta</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('departemen.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('departemen.pendeta.index') }}">Data Pendeta</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                                </ol>
                            </nav>
                        </div>
                        <a href="{{ route('departemen.pendeta.index') }}" class="btn btn-outline-primary btn-icon-text">
                            <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-content py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-shadow">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="card-title mb-0 text-dark"><i class="mdi mdi-form-select mr-2"></i>Form Pendeta Baru</h5>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger border-left-danger">
                                    <i class="mdi mdi-alert-circle mr-2"></i>
                                    <strong>Mohon periksa kesalahan berikut:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="forms-sample" action="{{ route('departemen.pendeta.store') }}" method="POST">
                                @csrf

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       placeholder="Masukkan Password">
                                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                                    <i class="mdi mdi-eye"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_pendeta" class="form-label">Nama Pendeta</label>
                                            <input type="text" name="nama_pendeta" id="nama_pendeta"
                                                   class="form-control @error('nama_pendeta') is-invalid @enderror"
                                                   placeholder="Masukkan Nama Pendeta"
                                                   value="{{ old('nama_pendeta') }}">
                                            @error('nama_pendeta')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_telp" class="form-label">No. Telepon</label>
                                            <input type="text" name="no_telp" id="no_telp"
                                                   class="form-control @error('no_telp') is-invalid @enderror"
                                                   placeholder="Masukkan No. Telepon"
                                                   value="{{ old('no_telp') }}">
                                            @error('no_telp')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="region_id" class="form-label">Region</label>
                                            <select name="region_id" id="region_id"
                                                    class="form-select @error('region_id') is-invalid @enderror">
                                                @foreach ($regions as $region)
                                                    <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                                        {{ $region->nama_region }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('region_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="departemen_id" class="form-label">Departemen</label>
                                            <select name="departemen_id" id="departemen_id"
                                                    class="form-select @error('departemen_id') is-invalid @enderror">
                                                <option value="">Pilih Departemen</option>
                                                @foreach ($departemens as $departemen)
                                                    <option value="{{ $departemen->id }}" {{ old('departemen_id') == $departemen->id ? 'selected' : '' }}>
                                                        {{ $departemen->nama_departemen }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('departemen_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea name="alamat" id="alamat"
                                                      class="form-control @error('alamat') is-invalid @enderror"
                                                      rows="3"
                                                      placeholder="Masukkan Alamat (Opsional)">{{ old('alamat') }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-footer border-top pt-4 d-flex justify-content-end">
                                    <button type="reset" class="btn btn-outline-secondary me-3">
                                        <i class="mdi mdi-autorenew btn-icon-prepend"></i>
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="mdi mdi-content-save btn-icon-prepend"></i>
                                        Simpan Data
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .card-shadow {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: none;
        border-radius: 0.375rem;
    }
    .section-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e1e5eb;
    }
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    .form-control, .form-select {
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
    }
    .form-footer {
        background-color: #f8f9fa;
        border-radius: 0 0 0.375rem 0.375rem;
    }
    .toggle-password {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    .alert {
        border-left: 4px solid;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(function(button) {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="mdi mdi-eye"></i>' : '<i class="mdi mdi-eye-off"></i>';
            });
        });
    });
</script>
@endsection
