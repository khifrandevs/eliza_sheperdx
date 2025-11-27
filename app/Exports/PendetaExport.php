<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PendetaExport implements WithMultipleSheets
{
    protected $pendeta;

    public function __construct($pendeta)
    {
        $this->pendeta = $pendeta;
    }

    public function sheets(): array
    {
        return [
            new PendetaSummarySheet($this->pendeta),
            new PerlawatanSheet($this->pendeta->perlawatans),
            new PenjadwalanSheet($this->pendeta->penjadwalans),
        ];
    }
}

class PendetaSummarySheet implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithTitle
{
    protected $pendeta;

    public function __construct($pendeta)
    {
        $this->pendeta = $pendeta;
    }

    public function collection()
    {
        return collect([$this->pendeta]);
    }

    public function headings(): array
    {
        return [
            'ID Akun',
            'Nama Pendeta',
            'No Telepon',
            'Alamat',
            'Jumlah Perlawatan (Sebulan)',
            'Jumlah Penjadwalan (Sebulan)',
            'Kategori',
        ];
    }

    public function map($pendeta): array
    {
        return [
            $pendeta->id,
            $pendeta->nama_pendeta,
            $pendeta->no_telepon ?? '-',
            $pendeta->alamat ?? '-',
            $pendeta->jumlah_perlawatan,
            $pendeta->jumlah_penjadwalan,
            $pendeta->kategori,
        ];
    }

    public function title(): string
    {
        return 'Summary';
    }
}

class PerlawatanSheet implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithTitle
{
    protected $perlawatans;

    public function __construct($perlawatans)
    {
        $this->perlawatans = $perlawatans;
    }

    public function collection()
    {
        return $this->perlawatans;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Anggota ID',
            'Tanggal',
            'Lokasi',
            'Catatan',
            'Gambar Bukti',
        ];
    }

    public function map($perlawatan): array
    {
        return [
            $perlawatan->id,
            $perlawatan->anggota_id,
            \Carbon\Carbon::parse($perlawatan->tanggal)->format('d-m-Y'),
            $perlawatan->lokasi,
            $perlawatan->catatan ?? '-',
            $perlawatan->gambar_bukti ? 'public/gambar_bukti/' . $perlawatan->gambar_bukti : '-',
        ];
    }

    public function title(): string
    {
        return 'Perlawatan';
    }
}

class PenjadwalanSheet implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithTitle
{
    protected $penjadwalans;

    public function __construct($penjadwalans)
    {
        $this->penjadwalans = $penjadwalans;
    }

    public function collection()
    {
        return $this->penjadwalans;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Judul Kegiatan',
            'Deskripsi',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Lokasi',
        ];
    }

    public function map($penjadwalan): array
    {
        return [
            $penjadwalan->id,
            $penjadwalan->judul_kegiatan,
            $penjadwalan->deskripsi ?? '-',
            \Carbon\Carbon::parse($penjadwalan->tanggal_mulai)->format('d-m-Y'),
            \Carbon\Carbon::parse($penjadwalan->tanggal_selesai)->format('d-m-Y'),
            $penjadwalan->lokasi,
        ];
    }

    public function title(): string
    {
        return 'Penjadwalan';
    }
}