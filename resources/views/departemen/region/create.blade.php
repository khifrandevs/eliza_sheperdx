@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <section class="section-header">
        <div class="row">
            <div class="col-12">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4 class="card-title mb-1">Tambah Region</h4>
                        <p class="card-description mb-0 text-muted">Form untuk menambahkan region baru</p>
                    </div>
                    <a href="{{ route('departemen.region.index') }}" class="btn btn-light btn-icon-text">
                        <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form class="forms-sample" action="{{ route('departemen.region.store') }}" method="POST">
                            @csrf
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Kode Region</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="kode_region" 
                                                   class="form-control form-control-sm @error('kode_region') is-invalid @enderror" 
                                                   placeholder="Masukkan Kode Region" 
                                                   value="{{ old('kode_region') }}">
                                            @error('kode_region')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Nama Region</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nama_region" 
                                                   class="form-control form-control-sm @error('nama_region') is-invalid @enderror" 
                                                   placeholder="Masukkan Nama Region" 
                                                   value="{{ old('nama_region') }}">
                                            @error('nama_region')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Deskripsi</label>
                                        <div class="col-sm-10">
                                            <textarea name="deskripsi" 
                                                      class="form-control form-control-sm @error('deskripsi') is-invalid @enderror" 
                                                      rows="3" 
                                                      placeholder="Masukkan Deskripsi (Opsional)">{{ old('deskripsi') }}</textarea>
                                            @error('deskripsi')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-footer border-top pt-4">
                                <button type="reset" class="btn btn-light me-2">
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
    </section>
</div>
@endsection