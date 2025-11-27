@extends('superadmin.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Tambah Pendeta</h4>
                        <a href="{{ route('superadmin.pendeta.index') }}" class="btn btn-light btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <p class="card-description mb-3">Form untuk menambahkan pendeta baru</p>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form class="forms-sample" action="{{ route('superadmin.pendeta.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Region</label>
                                    <select name="region_id" id="region_id" class="form-control form-control-sm @error('region_id') is-invalid @enderror">
                                        <option value="">-- Pilih Region --</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>{{ $region->nama_region }}</option>
                                        @endforeach
                                    </select>
                                    @error('region_id')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                
                                <div class="form-group">
                                    <label>Nama Pendeta</label>
                                    <input type="text" name="nama_pendeta" class="form-control form-control-sm @error('nama_pendeta') is-invalid @enderror" value="{{ old('nama_pendeta') }}">
                                    @error('nama_pendeta')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control form-control-sm @error('alamat') is-invalid @enderror" rows="2">{{ old('alamat') }}</textarea>
                                    @error('alamat')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Departemen</label>
                                    <select name="departemen_id" id="departemen_id" class="form-control form-control-sm @error('departemen_id') is-invalid @enderror">
                                        <option value="">-- Pilih Departemen --</option>
                                        @foreach ($departemens as $departemen)
                                            <option value="{{ $departemen->id }}" data-region-id="{{ $departemen->region_id }}" {{ old('departemen_id') == $departemen->id ? 'selected' : '' }}>{{ $departemen->nama_departemen }}</option>
                                        @endforeach
                                    </select>
                                    @error('departemen_id')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="form-group">
                                    <label>Gereja</label>
                                    <select name="gereja_id" id="gereja_id" class="form-control form-control-sm @error('gereja_id') is-invalid @enderror">
                                        <option value="">-- Pilih Gereja --</option>
                                        @foreach ($gerejas as $gereja)
                                            <option value="{{ $gereja->id }}" data-region-id="{{ $gereja->region_id }}" {{ old('gereja_id') == $gereja->id ? 'selected' : '' }}>{{ $gereja->nama_gereja }}</option>
                                        @endforeach
                                    </select>
                                    @error('gereja_id')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="form-group">
                                    <label>Jabatan (opsional)</label>
                                    <select name="jabatan_id" id="jabatan_id" class="form-control form-control-sm @error('jabatan_id') is-invalid @enderror">
                                        <option value="">-- Pilih Jabatan --</option>
                                        @foreach ($jabatans as $jabatan)
                                            <option value="{{ $jabatan->id }}" {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>{{ $jabatan->jabatan }}</option>
                                        @endforeach
                                    </select>
                                    @error('jabatan_id')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Mulai Jabatan</label>
                                    <input type="date" name="jabatan_tanggal_awal" class="form-control form-control-sm @error('jabatan_tanggal_awal') is-invalid @enderror" value="{{ old('jabatan_tanggal_awal', now()->toDateString()) }}">
                                    @error('jabatan_tanggal_awal')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="no_telp" class="form-control form-control-sm @error('no_telp') is-invalid @enderror" value="{{ old('no_telp') }}">
                                    @error('no_telp')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-group input-group-sm">
                                        <input type="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror">
                                        <div class="input-group-append">
                                            <span class="input-group-text" style="cursor: pointer;">
                                                <i class="mdi mdi-eye-off toggle-password"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-3 pt-3 border-top">
                            <button type="reset" class="btn btn-light btn-sm me-2">
                                <i class="mdi mdi-autorenew"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="mdi mdi-content-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Password toggle
        $('.toggle-password').click(function() {
            const passwordInput = $(this).closest('.input-group').find('input');
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).toggleClass('mdi-eye-off mdi-eye');
        });

        // Filter departemen dan gereja berdasarkan region_id
        $('#region_id').change(function() {
            const regionId = $(this).val();
            $('#departemen_id, #gereja_id').val('').trigger('change');
            
            if (regionId) {
                $('#departemen_id option').hide();
                $('#gereja_id option').hide();
                $('#departemen_id option[value=""], #departemen_id option[data-region-id="'+regionId+'"]').show();
                $('#gereja_id option[value=""], #gereja_id option[data-region-id="'+regionId+'"]').show();
            } else {
                $('#departemen_id option, #gereja_id option').show();
            }
        });
    });
</script>
@endsection
@endsection
