@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <section class="section-header">
        <div class="row">
            <div class="col-12">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4 class="card-title mb-1">Tambah Gereja</h4>
                        <p class="card-description mb-0 text-muted">Form untuk menambahkan gereja baru</p>
                    </div>
                    <a href="{{ route('departemen.gereja.index') }}" class="btn btn-light btn-icon-text">
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

                        <form class="forms-sample" action="{{ route('departemen.gereja.store') }}" method="POST">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Nama Gereja</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nama_gereja"
                                                   class="form-control form-control-sm @error('nama_gereja') is-invalid @enderror"
                                                   placeholder="Masukkan Nama Gereja"
                                                   value="{{ old('nama_gereja') }}">
                                            @error('nama_gereja')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Region</label>
                                        <div class="col-sm-9">
                                            <select name="region_id" class="form-control form-control-sm @error('region_id') is-invalid @enderror">
                                                @foreach ($regions as $region)
                                                    <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>{{ $region->nama_region }}</option>
                                                @endforeach
                                            </select>
                                            @error('region_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Pilih Pendeta</label>
                                        <div class="col-sm-10">
                                            @if($pendetas->count() > 0)
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="mb-0">
                                                            <i class="mdi mdi-account-multiple text-primary me-2"></i>
                                                            Pendeta dari Departemen Anda
                                                        </h6>
                                                        <small class="text-muted">Pilih satu atau lebih pendeta untuk ditugaskan ke gereja ini</small>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            @foreach($pendetas as $pendeta)
                                                                <div class="col-md-6 mb-3">
                                                                    <div class="card border">
                                                                        <div class="card-body p-3">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input"
                                                                                       type="checkbox"
                                                                                       name="pendeta_ids[]"
                                                                                       value="{{ $pendeta->id }}"
                                                                                       id="pendeta_{{ $pendeta->id }}"
                                                                                       {{ old('pendeta_ids') && in_array($pendeta->id, old('pendeta_ids')) ? 'checked' : '' }}>
                                                                                <label class="form-check-label w-100" for="pendeta_{{ $pendeta->id }}">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <i class="mdi mdi-account-circle text-primary me-2"></i>
                                                                                        <div class="flex-grow-1">
                                                                                            <strong>{{ $pendeta->nama_pendeta }}</strong>
                                                                                            <br>
                                                                                            <small class="text-muted">
                                                                                                <i class="mdi mdi-identifier me-1"></i>{{ $pendeta->id_akun }}
                                                                                                <span class="mx-2">•</span>
                                                                                                <i class="mdi mdi-phone me-1"></i>{{ $pendeta->no_telp }}
                                                                                            </small>
                                                                                            @if($pendeta->gereja_id)
                                                                                                <br>
                                                                                                <small class="text-warning">
                                                                                                    <i class="mdi mdi-alert-circle-outline me-1"></i>
                                                                                                    Saat ini ditugaskan ke: {{ $pendeta->gereja->nama_gereja }}
                                                                                                </small>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <div class="mt-3">
                                                            <small class="text-muted">
                                                                <i class="mdi mdi-information-outline me-1"></i>
                                                                Jika Anda memilih pendeta yang sudah ditugaskan ke gereja lain, mereka akan dipindahkan ke gereja ini.
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    <i class="mdi mdi-information-outline me-2"></i>
                                                    Tidak ada pendeta di departemen Anda untuk ditugaskan ke gereja ini.
                                                </div>
                                            @endif
                                            @error('pendeta_ids')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Alamat</label>
                                        <div class="col-sm-10">
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
