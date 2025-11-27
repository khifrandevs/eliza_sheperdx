@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Edit Pendeta</h4>
                            <p class="card-description mb-0">Form untuk mengedit data pendeta</p>
                        </div>
                        <a href="{{ route('departemen.pendeta.index') }}" class="btn btn-light btn-icon-text">
                            <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
                            Kembali
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="forms-sample" action="{{ route('departemen.pendeta.update', $pendeta) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">ID Akun</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="id_akun"
                                               class="form-control form-control-sm @error('id_akun') is-invalid @enderror"
                                               placeholder="Masukkan ID Akun"
                                               value="{{ old('id_akun', $pendeta->id_akun) }}">
                                        @error('id_akun')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="password"
                                               class="form-control form-control-sm @error('password') is-invalid @enderror"
                                               placeholder="Kosongkan jika tidak diubah">
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Nama Pendeta</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_pendeta"
                                               class="form-control form-control-sm @error('nama_pendeta') is-invalid @enderror"
                                               placeholder="Masukkan Nama Pendeta"
                                               value="{{ old('nama_pendeta', $pendeta->nama_pendeta) }}">
                                        @error('nama_pendeta')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">No. Telp</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="no_telp"
                                               class="form-control form-control-sm @error('no_telp') is-invalid @enderror"
                                               placeholder="Masukkan No. Telp"
                                               value="{{ old('no_telp', $pendeta->no_telp) }}">
                                        @error('no_telp')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Region</label>
                                    <div class="col-sm-9">
                                        <select name="region_id_display" class="form-control form-control-sm" disabled>
                                            @foreach ($regions as $region)
                                                <option value="{{ $region->id }}" {{ $pendeta->region_id == $region->id ? 'selected' : '' }}>{{ $region->nama_region }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="region_id" value="{{ $pendeta->region_id }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Departemen</label>
                                    <div class="col-sm-9">
                                        <select name="departemen_id_display" class="form-control form-control-sm" disabled>
                                            @foreach ($departemens as $departemen)
                                                <option value="{{ $departemen->id }}" {{ $pendeta->departemen_id == $departemen->id ? 'selected' : '' }}>{{ $departemen->nama_departemen }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="departemen_id" value="{{ $pendeta->departemen_id }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Gereja</label>
                                    <div class="col-sm-9">
                                        <select name="gereja_id_display" class="form-control form-control-sm" disabled>
                                            @foreach ($gerejas as $gereja)
                                                <option value="{{ $gereja->id }}" {{ $pendeta->gereja_id == $gereja->id ? 'selected' : '' }}>{{ $gereja->nama_gereja }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="gereja_id" value="{{ $pendeta->gereja_id }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <textarea name="alamat"
                                                  class="form-control form-control-sm @error('alamat') is-invalid @enderror"
                                                  placeholder="Masukkan Alamat (Opsional)">{{ old('alamat', $pendeta->alamat) }}</textarea>
                                        @error('alamat')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <button type="reset" class="btn btn-light me-2">
                                <i class="mdi mdi-autorenew btn-icon-prepend"></i>
                                Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save btn-icon-prepend"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
