<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanTahunanExport implements WithMultipleSheets
{
    protected $jenisBarang;
    protected $peminjaman;
    protected $barangMasuk;
    protected $barangKeluar;
    protected $pengajuan;
    protected $year;

    public function __construct($jenisBarang, $peminjaman, $barangMasuk, $barangKeluar, $pengajuan, $year)
    {
        $this->jenisBarang = $jenisBarang;
        $this->peminjaman = $peminjaman;
        $this->barangMasuk = $barangMasuk;
        $this->barangKeluar = $barangKeluar;
        $this->pengajuan = $pengajuan;
        $this->year = $year;
    }

    public function sheets(): array
    {
        $admin = [
            new LaporanBarangSheet($this->jenisBarang),
            new LaporanTahunanPeminjamanSheet($this->peminjaman, $this->year),
            new LaporanTahunanBarangMasukSheet($this->barangMasuk, $this->year),
            new LaporanTahunanBarangKeluarSheet($this->barangKeluar, $this->year),
            new LaporanTahunanPengajuanSheet($this->pengajuan, $this->year)
        ];

        $kepala = [
            new LaporanBarangSheet($this->jenisBarang),
            new LaporanTahunanBarangMasukSheet($this->barangMasuk, $this->year),
            new LaporanTahunanBarangKeluarSheet($this->barangKeluar, $this->year),
            new LaporanTahunanPengajuanSheet($this->pengajuan, $this->year)
        ];
        $bendahara = [
            new LaporanTahunanPengajuanSheet($this->pengajuan, $this->year)

        ];
        /** @var User $user */
        $user = auth()->user();

        return ($user->hasRole('admin') ? $admin : ($user->hasRole('kepala_sekolah') ? $kepala : $bendahara))
        ;
    }
}