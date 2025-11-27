@extends('superadmin.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="card-title mb-0">Edit Permohonan Perpindahan</h4>
                            <p class="card-description mb-0">Form untuk mengedit permohonan perpindahan</p>
                        </div>
                        <a href="{{ route('superadmin.permohonan_perpindahan.index') }}" class="btn btn-light btn-sm">
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
                    
                    <form class="forms-sample" action="{{ route('superadmin.permohonan_perpindahan.update', $permohonan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pendeta</label>
                                    <select name="pendeta_id" class="form-control form-control-sm @error('pendeta_id') is-invalid @enderror">
                                        <option value="">-- Pilih Pendeta --</option>
                                        @foreach ($pendetas as $pendeta)
                                            <option value="{{ $pendeta->id }}" {{ old('pendeta_id', $permohonan->pendeta_id) == $pendeta->id ? 'selected' : '' }}>
                                                {{ $pendeta->nama_pendeta }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pendeta_id')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                
                                <div class="form-group">
                                    <label>Region Tujuan</label>
                                    <select name="region_tujuan_id" id="region_tujuan_id" class="form-control form-control-sm @error('region_tujuan_id') is-invalid @enderror">
                                        <option value="">-- Pilih Region Tujuan --</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}" {{ old('region_tujuan_id', $permohonan->region_tujuan_id) == $region->id ? 'selected' : '' }}>
                                                {{ $region->nama_region }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('region_tujuan_id')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control form-control-sm @error('status') is-invalid @enderror">
                                        <option value="pending" {{ old('status', $permohonan->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="disetujui" {{ old('status', $permohonan->status) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="ditolak" {{ old('status', $permohonan->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                    @error('status')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Region Asal</label>
                                    <select name="region_asal_id" id="region_asal_id" class="form-control form-control-sm @error('region_asal_id') is-invalid @enderror">
                                        <option value="">-- Pilih Region Asal --</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}" {{ old('region_asal_id', $permohonan->region_asal_id) == $region->id ? 'selected' : '' }}>
                                                {{ $region->nama_region }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('region_asal_id')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                
                                <div class="form-group">
                                    <label>Tanggal Permohonan</label>
                                    <input type="date" name="tanggal_permohonan" class="form-control form-control-sm @error('tanggal_permohonan') is-invalid @enderror" value="{{ old('tanggal_permohonan', $permohonan->tanggal_permohonan->format('Y-m-d')) }}">
                                    @error('tanggal_permohonan')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                
                                <div class="form-group">
                                    <label>Alasan</label>
                                    <textarea name="alasan" class="form-control form-control-sm @error('alasan') is-invalid @enderror" rows="2">{{ old('alasan', $permohonan->alasan) }}</textarea>
                                    @error('alasan')<small class="text-danger">{{ $message }}</small>@enderror
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
        // Filter region_tujuan_id agar tidak sama dengan region_asal_id
        const regionAsalSelect = $('#region_asal_id');
        const regionTujuanSelect = $('#region_tujuan_id');
        const allRegions = @json($regions);

        function updateRegionTujuanOptions(selectedRegionAsalId) {
            const currentSelected = '{{ old('region_tujuan_id', $permohonan->region_tujuan_id) }}';
            regionTujuanSelect.find('option:not(:first)').remove();
            
            allRegions.forEach(region => {
                if (region.id != selectedRegionAsalId) {
                    const selected = region.id == currentSelected ? 'selected' : '';
                    regionTujuanSelect.append(`<option value="${region.id}" ${selected}>${region.nama_region}</option>`);
                }
            });
        }

        regionAsalSelect.change(function() {
            updateRegionTujuanOptions($(this).val());
        });

        // Initialize filter based on initial region_asal_id
        if (regionAsalSelect.val()) {
            updateRegionTujuanOptions(regionAsalSelect.val());
        }
    });
</script>
@endsection
@endsection