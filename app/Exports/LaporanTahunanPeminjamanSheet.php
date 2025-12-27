<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanTahunanPeminjamanSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $data;
    protected $year;
    protected $rowNumber = 0;

    public function __construct($data, $year)
    {
        $this->data = $data;
        $this->year = $year;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Peminjaman',
            'Nama Peminjam',
            'Nama Barang',
            'Jenis Barang',
            'Kode Barang',
            'Status',
            'Tanggal Pengembalian',
            'Keterangan'
        ];
    }

    public function map($peminjaman): array
    {
        $rows = [];

        foreach ($peminjaman->peminjamanBarang as $item) {
            $this->rowNumber++;
            $rows[] = [
                $this->rowNumber,
                $peminjaman->tanggal_peminjaman->format('d/m/Y'),
                $peminjaman->nama_peminjam,
                $item->barang->nama_barang ?? '-',
                $item->barang->jenisBarang->jenis ?? '-',
                $item->barang->kode_barang ? $item->barang->jenisBarang->kode_utama . '' . $item->barang->kode_barang : '-',
                ucfirst($item->status),
                $peminjaman->tanggal_pengembalian ? $peminjaman->tanggal_pengembalian->format('d/m/Y') : '-',
                $item->catatan ?? $peminjaman->keterangan ?? '-'
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Peminjaman ' . $this->year;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ],
        ];
    }
}