<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendeta</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
        .filter-info { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Laporan Pendeta</h2>
    <div class="filter-info">
        <p>Filter: {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID Akun</th>
                <th>Nama Pendeta</th>
                <th>No. Telp</th>
                <th>Alamat</th>
                <th>Region</th>
                <th>Departemen</th>
                <th>Gereja</th>
                <th>Jumlah Perlawatan</th>
                <th>Jumlah Penjadwalan</th>
                <th>Dibuat</th>
                <th>Diperbarui</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendetas as $pendeta)
                <tr>
                    <td>{{ $pendeta->id_akun }}</td>
                    <td>{{ $pendeta->nama_pendeta }}</td>
                    <td>{{ $pendeta->no_telp ?? '-' }}</td>
                    <td>{{ $pendeta->alamat ?? '-' }}</td>
                    <td>{{ $pendeta->region->nama_region ?? '-' }}</td>
                    <td>{{ $pendeta->departemen->nama_departemen ?? '-' }}</td>
                    <td>{{ $pendeta->gereja->nama_gereja ?? '-' }}</td>
                    <td>{{ $pendeta->perlawatans->count() }}</td>
                    <td>{{ $pendeta->penjadwalans->count() }}</td>
                    <td>{{ \Carbon\Carbon::parse($pendeta->created_at)->format('d M Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($pendeta->updated_at)->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>