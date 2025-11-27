@extends('superadmin.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Edit Region</h4>
                            <p class="card-description mb-0">Form untuk mengedit data region</p>
                        </div>
                        <a href="{{ route('superadmin.region.index') }}" class="btn btn-light btn-icon-text">
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
                    
                    <form class="forms-sample" action="{{ route('superadmin.region.update', $region) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Kode Region</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="kode_region" class="form-control form-control-sm @error('kode_region') is-invalid @enderror" placeholder="Masukkan Kode Region" value="{{ old('kode_region', $region->kode_region) }}">
                                        @error('kode_region')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Nama Region</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_region" class="form-control form-control-sm @error('nama_region') is-invalid @enderror" placeholder="Masukkan Nama Region" value="{{ old('nama_region', $region->nama_region) }}">
                                        @error('nama_region')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Deskripsi</label>
                                    <div class="col-sm-9">
                                        <textarea name="deskripsi" class="form-control form-control-sm @error('deskripsi') is-invalid @enderror" placeholder="Masukkan Deskripsi (Opsional)">{{ old('deskripsi', $region->deskripsi) }}</textarea>
                                        @error('deskripsi')
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