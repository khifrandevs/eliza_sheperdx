@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Edit Anggota</h4>
                            <p class="card-description mb-0">Form untuk mengedit data anggota</p>
                        </div>
                        <a href="{{ route('departemen.anggota.index') }}" class="btn btn-light btn-icon-text">
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
                    
                    <form class="forms-sample" action="{{ route('departemen.anggota.update', $anggota) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Nama Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_anggota" 
                                               class="form-control form-control-sm @error('nama_anggota') is-invalid @enderror" 
                                               placeholder="Masukkan Nama Anggota" 
                                               value="{{ old('nama_anggota', $anggota->nama_anggota) }}">
                                        @error('nama_anggota')
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
                                               placeholder="Masukkan No. Telp (Opsional)" 
                                               value="{{ old('no_telp', $anggota->no_telp) }}">
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
                                    <label class="col-sm-3 col-form-label">Gereja</label>
                                    <div class="col-sm-9">
                                        <select name="gereja_id" class="form-control form-control-sm @error('gereja_id') is-invalid @enderror">
                                            <option value="">Pilih Gereja</option>
                                            @foreach ($gerejas as $gereja)
                                                <option value="{{ $gereja->id }}" {{ old('gereja_id', $anggota->gereja_id) == $gereja->id ? 'selected' : '' }}>{{ $gereja->nama_gereja }}</option>
                                            @endforeach
                                        </select>
                                        @error('gereja_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <textarea name="alamat" 
                                                  class="form-control form-control-sm @error('alamat') is-invalid @enderror" 
                                                  placeholder="Masukkan Alamat (Opsional)">{{ old('alamat', $anggota->alamat) }}</textarea>
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