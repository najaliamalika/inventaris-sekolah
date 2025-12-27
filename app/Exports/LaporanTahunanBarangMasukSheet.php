<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanTahunanBarangMasukSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
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
        $isFirstRow = true;
        $isFirstDetail = true;

        foreach ($barangMasuk->details as $detail) {
            // Ambil semua barang yang terkait dengan detail ini
            $barangItems = $detail->barangItems;
            $isFirstItemInDetail = true;

            if ($barangItems->isEmpty()) {
                // Jika tidak ada barang items, tampilkan satu row dengan data detail saja
                $this->rowNumber++;
                $rows[] = [
                    $this->rowNumber,
                    $isFirstRow ? $barangMasuk->tanggal->format('d/m/Y') : '',
                    $isFirstRow ? ucfirst($barangMasuk->kategori) : '',
                    $isFirstRow ? $barangMasuk->nama_supplier : '',
                    $detail->jenisBarang->jenis ?? '-',
                    '-',
                    '-',
                    $detail->jenisBarang->satuan ?? '-',
                    'Rp ' . number_format($detail->harga_satuan ?? 0, 0, ',', '.'),
                    'Rp ' . number_format(($detail->harga_satuan * $detail->jumlah), 0, ',', '.'),
                    $isFirstRow ? 'Rp ' . number_format($barangMasuk->total_harga, 0, ',', '.') : '',
                    $detail->keterangan ?? $barangMasuk->keterangan ?? '-'
                ];
                $isFirstRow = false;
                $isFirstDetail = false;
            } else {
                // Jika ada barang items, tampilkan row untuk setiap barang
                foreach ($barangItems as $barang) {
                    $this->rowNumber++;
                    $rows[] = [
                        $this->rowNumber,
                        $isFirstRow ? $barangMasuk->tanggal->format('d/m/Y') : '',
                        $isFirstRow ? ucfirst($barangMasuk->kategori) : '',
                        $isFirstRow ? $barangMasuk->nama_supplier : '',
                        $isFirstItemInDetail ? ($detail->jenisBarang->jenis ?? '-') : '',
                        $barang->kode_barang ? $detail->jenisBarang->kode_utama . $barang->kode_barang : '-',
                        $barang->nama_barang ?? '-',
                        $isFirstItemInDetail ? ($detail->jenisBarang->satuan ?? '-') : '',
                        $isFirstItemInDetail ? 'Rp ' . number_format($detail->harga_satuan ?? 0, 0, ',', '.') : '',
                        $isFirstItemInDetail ? 'Rp ' . number_format(($detail->harga_satuan * $detail->jumlah), 0, ',', '.') : '',
                        $isFirstRow ? 'Rp ' . number_format($barangMasuk->total_harga, 0, ',', '.') : '',
                        $detail->keterangan ?? $barangMasuk->keterangan ?? '-'
                    ];
                    $isFirstRow = false;
                    $isFirstDetail = false;
                    $isFirstItemInDetail = false;
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