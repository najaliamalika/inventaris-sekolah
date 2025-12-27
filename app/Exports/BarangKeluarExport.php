<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangKeluarExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
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
            'Jenis Barang',
            'Kategori',
            'Nama Barang (Item)',
            'Kode Barang',
            'Jumlah',
            'Penerima',
            'Keterangan'
        ];
    }

    public function map($barangKeluar): array
    {
        $rows = [];

        if ($barangKeluar->items->count() > 0) {
            foreach ($barangKeluar->items as $item) {
                $this->rowNumber++;
                $rows[] = [
                    $this->rowNumber,
                    $barangKeluar->tanggal->format('d/m/Y'),
                    $barangKeluar->jenisBarang->jenis ?? '-',
                    ucfirst(str_replace('_', ' ', $barangKeluar->kategori)),
                    $item->barang->nama_barang ?? '-',
                    $item?->barang?->kode_barang ? $item->barang->jenisBarang->kode_utama . '' . $item->barang->kode_barang : '-',
                    $barangKeluar->jumlah,
                    $barangKeluar->penerima ?? '-',
                    $barangKeluar->keterangan ?? '-'
                ];
            }
        } else {
            $this->rowNumber++;
            $rows[] = [
                $this->rowNumber,
                $barangKeluar->tanggal->format('d/m/Y'),
                $barangKeluar->jenisBarang->jenis ?? '-',
                ucfirst(str_replace('_', ' ', $barangKeluar->kategori)),
                '-',
                '-',
                $barangKeluar->jumlah,
                $barangKeluar->penerima ?? '-',
                $barangKeluar->keterangan ?? '-'
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Laporan Barang Keluar';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}