@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <section class="section-header">
        <div class="row">
            <div class="col-12">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4 class="card-title mb-1">Tambah Permohonan Perpindahan</h4>
                        <p class="card-description mb-0 text-muted">Form untuk menambahkan permohonan perpindahan pendeta</p>
                    </div>
                    <a href="{{ route('departemen.permohonan_perpindahan.index') }}" class="btn btn-light btn-icon-text">
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
                        
                        <form class="forms-sample" action="{{ route('departemen.permohonan_perpindahan.store') }}" method="POST">
                            @csrf
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Pendeta</label>
                                        <div class="col-sm-9">
                                            <select name="pendeta_id" class="form-control form-control-sm @error('pendeta_id') is-invalid @enderror">
                                                <option value="">Pilih Pendeta</option>
                                                @foreach ($pendetas as $pendeta)
                                                    <option value="{{ $pendeta->id }}" {{ old('pendeta_id') == $pendeta->id ? 'selected' : '' }}>{{ $pendeta->nama_pendeta }}</option>
                                                @endforeach
                                            </select>
                                            @error('pendeta_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Region Asal</label>
                                        <div class="col-sm-9">
                                            <select name="region_asal_id" class="form-control form-control-sm @error('region_asal_id') is-invalid @enderror">
                                                <option value="">Pilih Region Asal</option>
                                                @foreach ($regions as $region)
                                                    <option value="{{ $region->id }}" {{ old('region_asal_id') == $region->id ? 'selected' : '' }}>{{ $region->nama_region }}</option>
                                                @endforeach
                                            </select>
                                            @error('region_asal_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Region Tujuan</label>
                                        <div class="col-sm-9">
                                            <select name="region_tujuan_id" class="form-control form-control-sm @error('region_tujuan_id') is-invalid @enderror">
                                                <option value="">Pilih Region Tujuan</option>
                                                @foreach ($regions as $region)
                                                    <option value="{{ $region->id }}" {{ old('region_tujuan_id') == $region->id ? 'selected' : '' }}>{{ $region->nama_region }}</option>
                                                @endforeach
                                            </select>
                                            @error('region_tujuan_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tanggal Permohonan</label>
                                        <div class="col-sm-9">
                                            <input type="date" name="tanggal_permohonan" 
                                                   class="form-control form-control-sm @error('tanggal_permohonan') is-invalid @enderror" 
                                                   value="{{ old('tanggal_permohonan') }}">
                                            @error('tanggal_permohonan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Alasan</label>
                                        <div class="col-sm-10">
                                            <textarea name="alasan" 
                                                      class="form-control form-control-sm @error('alasan') is-invalid @enderror" 
                                                      rows="3" 
                                                      placeholder="Masukkan Alasan Perpindahan">{{ old('alasan') }}</textarea>
                                            @error('alasan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-sm-10">
                                            <select name="status" class="form-control form-control-sm @error('status') is-invalid @enderror">
                                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                            @error('status')
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