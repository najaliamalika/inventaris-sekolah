<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanExport;
use App\Exports\BarangMasukExport;
use App\Exports\BarangKeluarExport;
use App\Exports\PengajuanExport;
use App\Exports\LaporanTahunanExport;
use App\Models\JenisBarang;

class ReportController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        return view(
            'reports.index',
            [
                'isAdmin' => $user->hasRole('admin'),
                'isKepala' => $user->hasRole('kepala_sekolah'),
                'isBendahara' => $user->hasRole('bendahara')
            ]
        );
    }

    // LAPORAN TAHUNAN (SEMUA DATA DALAM 1 FILE)
    public function laporanTahunan(Request $request)
    {
        $request->validate([
            'year' => 'required|numeric',
            'format' => 'required|in:excel,pdf'
        ]);

        $year = $request->year;

        // Ambil semua data berdasarkan tahun
        $jenisBarang = JenisBarang::with(['barang'])
            ->orderBy('jenis', 'asc')
            ->get();

        $peminjaman = Peminjaman::with(['peminjamanBarang.barang.jenisBarang'])
            ->whereYear('tanggal_peminjaman', $year)
            ->orderBy('tanggal_peminjaman', 'desc')
            ->get();

        $barangMasuk = BarangMasuk::with(['details.jenisBarang', 'details.barangItems'])
            ->whereYear('tanggal', $year)
            ->orderBy('tanggal', 'desc')
            ->get();

        $barangKeluar = BarangKeluar::with(['jenisBarang', 'items.barang.jenisBarang'])
            ->whereYear('tanggal', $year)
            ->orderBy('tanggal', 'desc')
            ->get();

        $pengajuan = Pengajuan::with(['jenisBarang', 'perbaikanItems.barang.jenisBarang'])
            ->whereYear('tanggal', $year)
            ->orderBy('tanggal', 'desc')
            ->get();

        if ($request->input('format') === 'excel') {
            return Excel::download(
                new LaporanTahunanExport($jenisBarang, $peminjaman, $barangMasuk, $barangKeluar, $pengajuan, $year),
                'laporan-tahunan-' . $year . '.xlsx'
            );
        }

        // PDF
        $pdf = PDF::loadView('reports.pdf.laporan-tahunan', [
            'jenisBarang' => $jenisBarang,
            'peminjaman' => $peminjaman,
            'barangMasuk' => $barangMasuk,
            'barangKeluar' => $barangKeluar,
            'pengajuan' => $pengajuan,
            'year' => $year
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-tahunan-' . $year . '.pdf');
    }

    // PEMINJAMAN REPORTS (RANGE)
    public function peminjamanReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:excel,pdf'
        ]);

        $query = Peminjaman::with(['peminjamanBarang.barang.jenisBarang'])
            ->whereBetween('tanggal_peminjaman', [$request->start_date, $request->end_date])
            ->orderBy('tanggal_peminjaman', 'desc');

        $data = $query->get();

        if ($request->input('format') === 'excel') {
            return Excel::download(
                new PeminjamanExport($data, $request->all()),
                'laporan-peminjaman-' . now()->format('Y-m-d') . '.xlsx'
            );
        }

        $pdf = PDF::loadView('reports.pdf.peminjaman', [
            'data' => $data,
            'filters' => $request->all()
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-peminjaman-' . now()->format('Y-m-d') . '.pdf');
    }

    // BARANG MASUK REPORTS (RANGE)
    public function barangMasukReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:excel,pdf'
        ]);

        $query = BarangMasuk::with(['details.jenisBarang', 'details.barangItems'])
            ->whereBetween('tanggal', [$request->start_date, $request->end_date])
            ->orderBy('tanggal', 'desc');

        $data = $query->get();

        if ($request->input('format') === 'excel') {
            return Excel::download(
                new BarangMasukExport($data, $request->all()),
                'laporan-barang-masuk-' . now()->format('Y-m-d') . '.xlsx'
            );
        }

        $pdf = PDF::loadView('reports.pdf.barang-masuk', [
            'data' => $data,
            'filters' => $request->all()
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-barang-masuk-' . now()->format('Y-m-d') . '.pdf');
    }

    // BARANG KELUAR REPORTS (RANGE)
    public function barangKeluarReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:excel,pdf'
        ]);

        $query = BarangKeluar::with(['jenisBarang', 'items.barang.jenisBarang'])
            ->whereBetween('tanggal', [$request->start_date, $request->end_date])
            ->orderBy('tanggal', 'desc');

        $data = $query->get();

        if ($request->input('format') === 'excel') {
            return Excel::download(
                new BarangKeluarExport($data, $request->all()),
                'laporan-barang-keluar-' . now()->format('Y-m-d') . '.xlsx'
            );
        }

        $pdf = PDF::loadView('reports.pdf.barang-keluar', [
            'data' => $data,
            'filters' => $request->all()
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-barang-keluar-' . now()->format('Y-m-d') . '.pdf');
    }

    // PENGAJUAN REPORTS (RANGE)
    public function pengajuanReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:excel,pdf'
        ]);

        $query = Pengajuan::with(['jenisBarang', 'perbaikanItems.barang.jenisBarang'])
            ->whereBetween('tanggal', [$request->start_date, $request->end_date])
            ->orderBy('tanggal', 'desc');

        $data = $query->get();

        if ($request->input('format') === 'excel') {
            return Excel::download(
                new PengajuanExport($data, $request->all()),
                'laporan-pengajuan-' . now()->format('Y-m-d') . '.xlsx'
            );
        }

        $pdf = PDF::loadView('reports.pdf.pengajuan', [
            'data' => $data,
            'filters' => $request->all()
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pengajuan-' . now()->format('Y-m-d') . '.pdf');
    }
}