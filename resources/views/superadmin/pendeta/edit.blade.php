@extends('superadmin.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="card-title mb-0">Edit Pendeta</h4>
                            <p class="card-description mb-0">Form untuk mengedit data pendeta</p>
                        </div>
                        <a href="{{ route('superadmin.pendeta.index') }}" class="btn btn-light btn-sm">
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

                    <form class="forms-sample" action="{{ route('superadmin.pendeta.update', $pendeta) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ID Akun</label>
                                    <input type="text" name="id_akun" class="form-control form-control-sm @error('id_akun') is-invalid @enderror" value="{{ old('id_akun', $pendeta->id_akun) }}">
                                    @error('id_akun')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="form-group">
                                    <label>Nama Pendeta</label>
                                    <input type="text" name="nama_pendeta" class="form-control form-control-sm @error('nama_pendeta') is-invalid @enderror" value="{{ old('nama_pendeta', $pendeta->nama_pendeta) }}">
                                    @error('nama_pendeta')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="form-group">
                                    <label>Region</label>
                                    <select name="region_id_display" class="form-control form-control-sm" disabled>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}" {{ $pendeta->region_id == $region->id ? 'selected' : '' }}>{{ $region->nama_region }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="region_id" value="{{ $pendeta->region_id }}">
                                </div>

                                <div class="form-group">
                                    <label>Departemen</label>
                                    <select name="departemen_id_display" class="form-control form-control-sm" disabled>
                                        @foreach ($departemens as $departemen)
                                            <option value="{{ $departemen->id }}" {{ $pendeta->departemen_id == $departemen->id ? 'selected' : '' }}>{{ $departemen->nama_departemen }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="departemen_id" value="{{ $pendeta->departemen_id }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="no_telp" class="form-control form-control-sm @error('no_telp') is-invalid @enderror" value="{{ old('no_telp', $pendeta->no_telp) }}">
                                    @error('no_telp')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="form-group">
                                    <label>Gereja</label>
                                    <select name="gereja_id_display" class="form-control form-control-sm" disabled>
                                        <option value="">-- Pilih Gereja --</option>
                                        @foreach ($gerejas as $gereja)
                                            <option value="{{ $gereja->id }}" {{ $pendeta->gereja_id == $gereja->id ? 'selected' : '' }}>{{ $gereja->nama_gereja }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="gereja_id" value="{{ $pendeta->gereja_id }}">
                                </div>

                                <div class="form-group">
                                    <label>Jabatan (opsional)</label>
                                    <select name="jabatan_id" id="jabatan_id" class="form-control form-control-sm @error('jabatan_id') is-invalid @enderror">
                                        <option value="">-- Pilih Jabatan --</option>
                                        @foreach ($jabatans as $jabatan)
                                            <option value="{{ $jabatan->id }}" {{ old('jabatan_id', optional($jabatanAktif)->jabatan_id) == $jabatan->id ? 'selected' : '' }}>{{ $jabatan->jabatan }}</option>
                                        @endforeach
                                    </select>
                                    @error('jabatan_id')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Mulai Jabatan</label>
                                    <input type="date" name="jabatan_tanggal_awal" class="form-control form-control-sm @error('jabatan_tanggal_awal') is-invalid @enderror" value="{{ old('jabatan_tanggal_awal', optional($jabatanAktif)->tanggal_awal ? optional($jabatanAktif)->tanggal_awal->format('Y-m-d') : now()->toDateString()) }}">
                                    @error('jabatan_tanggal_awal')<small class="text-danger">{{ $message }}</small>@enderror
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

                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control form-control-sm @error('alamat') is-invalid @enderror" rows="2">{{ old('alamat', $pendeta->alamat) }}</textarea>
                                    @error('alamat')<small class="text-danger">{{ $message }}</small>@enderror
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
