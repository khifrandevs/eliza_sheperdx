<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendeta - {{ $pendeta->nama_pendeta }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; vertical-align: middle; }
        th { background-color: #f2f2f2; }
        h1, h2 { text-align: center; }
        h2 { margin-top: 30px; }
        .image-cell img { max-width: 100px; max-height: 100px; object-fit: contain; }
        .image-cell .no-image { color: #888; font-style: italic; font-size: 10px; }
    </style>
</head>
<body>
    <h1>Laporan Pendeta: {{ $pendeta->nama_pendeta }}</h1>
    <p>Bulan: {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
    
    <h2>Ringkasan Pendeta</h2>
    <table>
        <thead>
            <tr>
                <th>ID Akun</th>
                <th>Nama Pendeta</th>
                <th>No Telepon</th>
                <th>Alamat</th>
                <th>Jumlah Perlawatan</th>
                <th>Jumlah Penjadwalan</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $pendeta->id }}</td>
                <td>{{ $pendeta->nama_pendeta }}</td>
                <td>{{ $pendeta->no_telepon ?? '-' }}</td>
                <td>{{ $pendeta->alamat ?? '-' }}</td>
                <td>{{ $pendeta->jumlah_perlawatan }}</td>
                <td>{{ $pendeta->jumlah_penjadwalan }}</td>
                <td>{{ $pendeta->kategori }}</td>
            </tr>
        </tbody>
    </table>

    <h2>Daftar Perlawatan</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Anggota ID</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Catatan</th>
                <th>Gambar Bukti</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pendeta->perlawatans as $perlawatan)
                <tr>
                    <td>{{ $perlawatan->id }}</td>
                    <td>{{ $perlawatan->anggota_id }}</td>
                    <td>{{ \Carbon\Carbon::parse($perlawatan->tanggal)->translatedFormat('d F Y') }}</td>
                    <td>{{ $perlawatan->lokasi }}</td>
                    <td>{{ $perlawatan->catatan ?? '-' }}</td>
                    <td class="image-cell">
                        @if ($perlawatan->gambar_bukti && file_exists(public_path('gambar_bukti/' . $perlawatan->gambar_bukti)))
                            <img src="{{ public_path('gambar_bukti/' . $perlawatan->gambar_bukti) }}" alt="Gambar Bukti {{ $perlawatan->id }}">
                        @else
                            <span class="no-image">Gambar tidak tersedia</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data perlawatan untuk bulan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Daftar Penjadwalan</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Kegiatan</th>
                <th>Deskripsi</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pendeta->penjadwalans as $penjadwalan)
                <tr>
                    <td>{{ $penjadwalan->id }}</td>
                    <td>{{ $penjadwalan->judul_kegiatan }}</td>
                    <td>{{ $penjadwalan->deskripsi ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($penjadwalan->tanggal_mulai)->translatedFormat('d F Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($penjadwalan->tanggal_selesai)->translatedFormat('d F Y') }}</td>
                    <td>{{ $penjadwalan->lokasi }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data penjadwalan untuk bulan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>