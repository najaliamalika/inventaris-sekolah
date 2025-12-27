<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanTahunanExport implements WithMultipleSheets
{
    protected $peminjaman;
    protected $barangMasuk;
    protected $barangKeluar;
    protected $pengajuan;
    protected $year;

    public function __construct($peminjaman, $barangMasuk, $barangKeluar, $pengajuan, $year)
    {
        $this->peminjaman = $peminjaman;
        $this->barangMasuk = $barangMasuk;
        $this->barangKeluar = $barangKeluar;
        $this->pengajuan = $pengajuan;
        $this->year = $year;
    }

    public function sheets(): array
    {
        $admin = [
            new LaporanTahunanPeminjamanSheet($this->peminjaman, $this->year),
        ];

        $kepala = [
            new LaporanTahunanBarangMasukSheet($this->barangMasuk, $this->year),
            new LaporanTahunanBarangKeluarSheet($this->barangKeluar, $this->year),
            new LaporanTahunanPengajuanSheet($this->pengajuan, $this->year)
        ];
        /** @var User $user */
        $user = auth()->user();

        return
            $user->hasRole('admin') ? $admin : $kepala
        ;
    }
}