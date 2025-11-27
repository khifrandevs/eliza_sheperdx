@extends('superadmin.layouts.app')

@section('konten')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Perpindahan Pendeta</h4>
                        <a href="{{ route('superadmin.pendeta.index') }}" class="btn btn-light btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <p class="card-description mb-3">Form untuk mencatat perpindahan pendeta antar region/gereja</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="forms-sample" action="{{ route('superadmin.pendeta.transfer.submit') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pendeta</label>
                                    <select name="pendeta_id" id="pendeta_id" class="form-control form-control-sm">
                                        <option value="">-- Pilih Pendeta --</option>
                                        @foreach ($pendetas as $p)
                                            <option value="{{ $p->id }}" data-region-id="{{ $p->region_id }}" data-gereja-id="{{ $p->gereja_id }}">{{ $p->nama_pendeta }} ({{ $p->id_akun }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Region Awal</label>
                                    <input type="text" id="region_awal_text" class="form-control form-control-sm" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Gereja Awal</label>
                                    <input type="text" id="gereja_awal_text" class="form-control form-control-sm" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Region Tujuan</label>
                                    <select name="region_tujuan_id" id="region_tujuan_id" class="form-control form-control-sm">
                                        <option value="">-- Pilih Region Tujuan --</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->nama_region }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Gereja Tujuan (opsional)</label>
                                    <select name="gereja_tujuan_id" id="gereja_tujuan_id" class="form-control form-control-sm">
                                        <option value="">-- Pilih Gereja Tujuan --</option>
                                        @foreach ($gerejas as $g)
                                            <option value="{{ $g->id }}" data-region-id="{{ $g->region_id }}">{{ $g->nama_gereja }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted d-block">Biarkan kosong bila pindah region saja, gereja tujuan akan ditetapkan oleh region tujuan.</small>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Perpindahan</label>
                                    <input type="date" name="tanggal_perpindahan" class="form-control form-control-sm" value="{{ now()->toDateString() }}">
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Aktif Melayani</label>
                                    <input type="date" name="tanggal_aktif_melayani" class="form-control form-control-sm" value="{{ now()->toDateString() }}">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3 pt-3 border-top">
                            <button type="reset" class="btn btn-light btn-sm me-2">
                                <i class="mdi mdi-autorenew"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="mdi mdi-content-save"></i> Simpan Perpindahan
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
    const pendetas = @json($pendetas);
    const regions = @json($regions);
    const gerejas = @json($gerejas);

    function findById(list, id) {
        return list.find(item => item.id === id);
    }

    function updateOriginFields(pendetaId) {
        const p = findById(pendetas, parseInt(pendetaId));
        if (!p) { document.getElementById('region_awal_text').value = ''; document.getElementById('gereja_awal_text').value = ''; return; }
        const region = findById(regions, p.region_id);
        const gereja = findById(gerejas, p.gereja_id);
        document.getElementById('region_awal_text').value = region ? region.nama_region : '-';
        document.getElementById('gereja_awal_text').value = gereja ? gereja.nama_gereja : '-';
    }

    function filterGerejaByRegion(regionId) {
        const select = document.getElementById('gereja_tujuan_id');
        Array.from(select.options).forEach(opt => {
            if (!opt.value) { opt.hidden = false; return; }
            opt.hidden = String(opt.getAttribute('data-region-id')) !== String(regionId);
        });
        select.value = '';
    }

    document.getElementById('pendeta_id').addEventListener('change', function() {
        updateOriginFields(this.value);
    });
    document.getElementById('region_tujuan_id').addEventListener('change', function() {
        filterGerejaByRegion(this.value);
    });
</script>
@endsection
@endsection
