@extends('departemen.layouts.app')

@section('konten')
<div class="content-wrapper">
    <!-- Header Section -->
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="font-weight-bold mb-2">Dashboard Departemen</h3>
                    <h6 class="text-muted mb-0">Semua sistem berjalan dengan lancar! 
                        <span class="text-primary">{{ $newPendetasCount }} pendeta baru</span> dalam 30 hari terakhir
                    </h6>
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-calendar"></i> {{ now()->format('d M Y') }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate">
                        <a class="dropdown-item" href="#"><i class="mdi mdi-calendar-today"></i> Hari Ini</a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-calendar-range"></i> 30 Hari Terakhir</a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-calendar-multiple"></i> 90 Hari Terakhir</a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-calendar-blank"></i> Semua Waktu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-md-6 grid-margin">
            <div class="row">
                <!-- Pendeta Card -->
                <div class="col-md-6 mb-4">
                    <div class="card card-tale">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <p class="mb-0">Total Pendeta</p>
                                <i class="mdi mdi-account-multiple icon-md"></i>
                            </div>
                            <div>
                                <h2 class="mb-2">{{ $totalPendetas }}</h2>
                                <small class="text-white">{{ $newPendetasCount }} baru (30 hari)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gereja Card -->
                <div class="col-md-6 mb-4">
                    <div class="card card-dark-blue">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <p class="mb-0">Total Gereja</p>
                                <i class="mdi mdi-church icon-md"></i>
                            </div>
                            <div>
                                <h2 class="mb-2">{{ $totalGerejas }}</h2>
                                <small class="text-white">Data gereja di region</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Anggota Card -->
                <div class="col-md-6 mb-4">
                    <div class="card card-light-blue">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <p class="mb-0">Total Anggota</p>
                                <i class="mdi mdi-account-group icon-md"></i>
                            </div>
                            <div>
                                <h2 class="mb-2">{{ $totalAnggotas }}</h2>
                                <small class="text-white">Data anggota gereja</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permohonan Card -->
                <div class="col-md-6 mb-4">
                    <div class="card card-light-danger">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <p class="mb-0">Permohonan Perpindahan</p>
                                <i class="mdi mdi-swap-horizontal icon-md"></i>
                            </div>
                            <div>
                                <h2 class="mb-2">{{ $permohonanCount }}</h2>
                                <small class="text-white">Data perpindahan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Pendeta Table -->
        <div class="col-md-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Pendeta Terbaru</h4>
                        <a href="{{ route('departemen.pendeta.index') }}" class="btn btn-sm btn-link">Lihat Semua</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Region</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentPendetas as $pendeta)
                                <tr>
                                    <td class="font-weight-bold">{{ $pendeta->nama }}</td>
                                    <td>{{ $pendeta->region->nama_region }}</td>
                                    <td>{{ $pendeta->created_at->format('d M Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection