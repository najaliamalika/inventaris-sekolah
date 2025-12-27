<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengajuanExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $data;
    protected $filters;
    protected $rowNumber = 0;

    public function __construct($data, $filters)
    {
        $this->data = $data;
        $this->filters = $filters;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Tipe',
            'Jenis Barang',
            'Nama Barang',
            'Item Perbaikan',
            'Jumlah',
            'Estimasi Biaya',
            'Status',
            'Alasan',
            'Catatan'
        ];
    }

    public function map($pengajuan): array
    {
        $this->rowNumber++;

        $itemPerbaikan = '-';
        if ($pengajuan->tipe === 'perbaikan' && $pengajuan->perbaikanItems->count() > 0) {
            $itemPerbaikan = $pengajuan->perbaikanItems->map(function ($item) {
                return $item->barang->nama_barang . ' (' . $item->barang->jenisBarang->kode_utama . '' . $item->barang->kode_barang . ')';
            })->implode(', ');
        }

        return [
            [
                $this->rowNumber,
                $pengajuan->tanggal->format('d/m/Y'),
                ucfirst($pengajuan->tipe),
                $pengajuan->jenisBarang->jenis ?? '-',
                $pengajuan->nama_barang ?? '-',
                $itemPerbaikan,
                $pengajuan->jumlah,
                'Rp ' . number_format($pengajuan->estimasi_biaya, 0, ',', '.'),
                ucfirst($pengajuan->status),
                $pengajuan->alasan,
                $pengajuan->catatan ?? '-'
            ]
        ];
    }

    public function title(): string
    {
        return 'Laporan Pengajuan';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}