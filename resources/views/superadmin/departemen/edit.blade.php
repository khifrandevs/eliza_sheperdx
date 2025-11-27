@extends('superadmin.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="card-title mb-0">Edit Departemen</h4>
                            <p class="card-description mb-0">Form untuk mengedit data departemen</p>
                        </div>
                        <a href="{{ route('superadmin.departemen.index') }}" class="btn btn-light btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form class="forms-sample" action="{{ route('superadmin.departemen.update', $departemen) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ID Akun</label>
                                    <input type="text" name="id_akun" class="form-control form-control-sm @error('id_akun') is-invalid @enderror" value="{{ old('id_akun', $departemen->id_akun) }}">
                                    @error('id_akun')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                
                                <div class="form-group">
                                    <label>Region</label>
                                    <select name="region_id" class="form-control form-control-sm @error('region_id') is-invalid @enderror">
                                        <option value="">-- Pilih Region --</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}" {{ old('region_id', $departemen->region_id) == $region->id ? 'selected' : '' }}>{{ $region->nama_region }}</option>
                                        @endforeach
                                    </select>
                                    @error('region_id')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Departemen</label>
                                    <input type="text" name="nama_departemen" class="form-control form-control-sm @error('nama_departemen') is-invalid @enderror" value="{{ old('nama_departemen', $departemen->nama_departemen) }}">
                                    @error('nama_departemen')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-group input-group-sm">
                                        <input type="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak ingin diubah">
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
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control form-control-sm @error('deskripsi') is-invalid @enderror" rows="2">{{ old('deskripsi', $departemen->deskripsi) }}</textarea>
                                    @error('deskripsi')<small class="text-danger">{{ $message }}</small>@enderror
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
    });
</script>
@endsection
@endsection