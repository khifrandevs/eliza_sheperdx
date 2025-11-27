@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Edit Permohonan Perpindahan</h3>
                    <h6 class="font-weight-normal mb-0">Form untuk mengedit data permohonan perpindahan</h6>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title">Edit Permohonan Perpindahan</h4>
                            <p class="card-description">Form untuk mengedit data permohonan perpindahan</p>
                        </div>
                        <a href="{{ route('departemen.permohonan_perpindahan.index') }}" class="btn btn-light btn-icon-text">
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
                    
                    <form class="forms-sample" action="{{ route('departemen.permohonan_perpindahan.update', $permohonan) }}" method="POST" id="permohonanForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" id="statusInput" value="{{ old('status', $permohonan->status) }}">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Pendeta</label>
                                    <div class="col-sm-9">
                                        <select name="pendeta_id" class="form-control form-control-sm @error('pendeta_id') is-invalid @enderror">
                                            <option value="">Pilih Pendeta</option>
                                            @foreach ($pendetas as $pendeta)
                                                <option value="{{ $pendeta->id }}" {{ old('pendeta_id', $permohonan->pendeta_id) == $pendeta->id ? 'selected' : '' }}>{{ $pendeta->nama_pendeta }}</option>
                                            @endforeach
                                        </select>
                                        @error('pendeta_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Region Asal</label>
                                    <div class="col-sm-9">
                                        <select name="region_asal_id" class="form-control form-control-sm @error('region_asal_id') is-invalid @enderror">
                                            <option value="">Pilih Region Asal</option>
                                            @foreach ($regions as $region)
                                                <option value="{{ $region->id }}" {{ old('region_asal_id', $permohonan->region_asal_id) == $region->id ? 'selected' : '' }}>{{ $region->nama_region }}</option>
                                            @endforeach
                                        </select>
                                        @error('region_asal_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Region Tujuan</label>
                                    <div class="col-sm-9">
                                        <select name="region_tujuan_id" class="form-control form-control-sm @error('region_tujuan_id') is-invalid @enderror">
                                            <option value="">Pilih Region Tujuan</option>
                                            @foreach ($regions as $region)
                                                <option value="{{ $region->id }}" {{ old('region_tujuan_id', $permohonan->region_tujuan_id) == $region->id ? 'selected' : '' }}>{{ $region->nama_region }}</option>
                                            @endforeach
                                        </select>
                                        @error('region_tujuan_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Tanggal Permohonan</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="tanggal_permohonan" 
                                               class="form-control form-control-sm @error('tanggal_permohonan') is-invalid @enderror" 
                                               value="{{ old('tanggal_permohonan', \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->format('Y-m-d')) }}">
                                        @error('tanggal_permohonan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Alasan</label>
                                    <div class="col-sm-9">
                                        <textarea name="alasan" 
                                                  class="form-control form-control-sm @error('alasan') is-invalid @enderror" 
                                                  placeholder="Masukkan Alasan Perpindahan">{{ old('alasan', $permohonan->alasan) }}</textarea>
                                        @error('alasan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Section with Buttons -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <div class="d-flex">
                                            @if($permohonan->status == 'pending')
                                                <button type="button" class="btn btn-success mr-2" onclick="setStatus('disetujui')">
                                                    <i class="mdi mdi-check-circle"></i> Setujui
                                                </button>
                                                <button type="button" class="btn btn-danger" onclick="setStatus('ditolak')">
                                                    <i class="mdi mdi-close-circle"></i> Tolak
                                                </button>
                                            @else
                                                <div class="status-badge">
                                                    @if($permohonan->status == 'disetujui')
                                                        <span class="badge badge-success p-2">DISETUJUI</span>
                                                    @elseif($permohonan->status == 'ditolak')
                                                        <span class="badge badge-danger p-2">DITOLAK</span>
                                                    @endif
                                                    <button type="button" class="btn btn-outline-secondary btn-sm ml-2" onclick="resetStatus()">
                                                        <i class="mdi mdi-autorenew"></i> Ubah Status
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        <small class="text-muted">Status saat ini: 
                                            @if($permohonan->status == 'pending')
                                                <span class="text-warning">Menunggu Persetujuan</span>
                                            @elseif($permohonan->status == 'disetujui')
                                                <span class="text-success">Disetujui</span>
                                            @elseif($permohonan->status == 'ditolak')
                                                <span class="text-danger">Ditolak</span>
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <button type="reset" class="btn btn-light me-2">
                                <i class="mdi mdi-autorenew btn-icon-prepend"></i>
                                Reset Form
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

<style>
    .status-badge {
        display: flex;
        align-items: center;
    }
</style>

<script>
    function setStatus(status) {
        document.getElementById('statusInput').value = status;
        document.getElementById('permohonanForm').submit();
    }
    
    function resetStatus() {
        document.getElementById('statusInput').value = 'pending';
        document.getElementById('permohonanForm').submit();
    }
</script>
@endsection