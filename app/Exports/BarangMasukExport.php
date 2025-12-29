<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangMasukExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
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
            'Kategori',
            'Nama Supplier',
            'Jenis Barang',
            'Kode Barang',
            'Nama Barang',
            'Satuan',
            'Harga Satuan',
            'Subtotal',
            'Total Harga',
            'Keterangan'
        ];
    }

    public function map($barangMasuk): array
    {
        $rows = [];

        foreach ($barangMasuk->details as $detail) {
            // Ambil semua barang yang terkait dengan detail ini
            $barangItems = $detail->barangItems;

            if ($barangItems->isEmpty()) {
                // Jika tidak ada barang items, tampilkan satu row dengan data detail saja
                $this->rowNumber++;
                $rows[] = [
                    $this->rowNumber,
                    $barangMasuk->tanggal->format('d/m/Y'),
                    ucfirst($barangMasuk->kategori),
                    $barangMasuk->nama_supplier,
                    $detail->jenisBarang->jenis ?? '-',
                    '-',
                    '-',
                    $detail->jenisBarang->satuan ?? '-',
                    'Rp ' . number_format($detail->harga_satuan ?? 0, 0, ',', '.'),
                    'Rp ' . number_format(($detail->harga_satuan * $detail->jumlah), 0, ',', '.'),
                    'Rp ' . number_format($barangMasuk->total_harga, 0, ',', '.'),
                    $detail->keterangan ?? $barangMasuk->keterangan ?? '-'
                ];
            } else {
                // Jika ada barang items, tampilkan row untuk setiap barang
                foreach ($barangItems as $barang) {
                    $this->rowNumber++;
                    $rows[] = [
                        $this->rowNumber,
                        $barangMasuk->tanggal->format('d/m/Y'),
                        ucfirst($barangMasuk->kategori),
                        $barangMasuk->nama_supplier,
                        $detail->jenisBarang->jenis,
                        $barang->kode_barang ? $detail->jenisBarang->kode_utama . $barang->kode_barang : '-',
                        $barang->nama_barang ?? '-',
                        $detail->jenisBarang->satuan,
                        'Rp ' . number_format($detail->harga_satuan ?? 0, 0, ',', '.'),
                        'Rp ' . number_format(($detail->harga_satuan * $detail->jumlah), 0, ',', '.'),
                        'Rp ' . number_format($barangMasuk->total_harga, 0, ',', '.'),
                        $detail->keterangan ?? $barangMasuk->keterangan ?? '-'
                    ];
                }
            }
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Laporan Barang Masuk';
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