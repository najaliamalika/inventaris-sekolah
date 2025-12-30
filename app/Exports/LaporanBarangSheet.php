<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanBarangSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $data;
    protected $rowNumber = 0;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Jenis Barang',
            'Kategori',
            'Nama Barang',
            'Kode Barang',
            'Kondisi',
        ];
    }

    public function map($jenisBarang): array
    {
        $rows = [];

        if ($jenisBarang->barang->count() > 0) {
            foreach ($jenisBarang->barang as $item) {
                $this->rowNumber++;
                $rows[] = [
                    $this->rowNumber,
                    $jenisBarang->jenis ? $jenisBarang->jenis : '-',
                    $jenisBarang->kategori ? ucfirst(str_replace('_', ' ', $jenisBarang->kategori)) : '-',
                    $item->nama_barang ?? '-',
                    $item->kode_barang ? $item->jenisBarang->kode_utama . '' . $item->kode_barang : '-',
                    $item->kondisi ? $item->kondisi : '-',
                ];
            }
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Data Barang';
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