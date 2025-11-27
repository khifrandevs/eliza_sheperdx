@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <section class="section-header">
        <div class="row">
            <div class="col-12">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4 class="card-title mb-1">Tambah Anggota</h4>
                        <p class="card-description mb-0 text-muted">Form untuk menambahkan anggota baru</p>
                    </div>
                    <a href="{{ route('departemen.anggota.index') }}" class="btn btn-light btn-icon-text">
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
                        
                        <form class="forms-sample" action="{{ route('departemen.anggota.store') }}" method="POST">
                            @csrf
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Nama Anggota</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nama_anggota" 
                                                   class="form-control form-control-sm @error('nama_anggota') is-invalid @enderror" 
                                                   placeholder="Masukkan Nama Anggota" 
                                                   value="{{ old('nama_anggota') }}">
                                            @error('nama_anggota')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">No. Telp</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="no_telp" 
                                                   class="form-control form-control-sm @error('no_telp') is-invalid @enderror" 
                                                   placeholder="Masukkan No. Telp (Opsional)" 
                                                   value="{{ old('no_telp') }}">
                                            @error('no_telp')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Gereja</label>
                                        <div class="col-sm-9">
                                            <select name="gereja_id" class="form-control form-control-sm @error('gereja_id') is-invalid @enderror">
                                                <option value="">Pilih Gereja</option>
                                                @foreach ($gerejas as $gereja)
                                                    <option value="{{ $gereja->id }}" {{ old('gereja_id') == $gereja->id ? 'selected' : '' }}>{{ $gereja->nama_gereja }}</option>
                                                @endforeach
                                            </select>
                                            @error('gereja_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <textarea name="alamat" 
                                                      class="form-control form-control-sm @error('alamat') is-invalid @enderror" 
                                                      rows="3" 
                                                      placeholder="Masukkan Alamat (Opsional)">{{ old('alamat') }}</textarea>
                                            @error('alamat')
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