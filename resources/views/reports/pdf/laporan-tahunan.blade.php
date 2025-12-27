<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Tahunan {{ $year }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
        }

        .cover-page {
            text-align: center;
            padding-top: 200px;
        }

        .cover-page h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .cover-page h2 {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .cover-page p {
            font-size: 14px;
            margin: 5px 0;
        }

        .section-break {
            page-break-before: always;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 14px;
        }

        .header p {
            margin: 3px 0;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 9px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 15px;
            font-size: 9px;
        }

        .status-disetujui {
            background-color: #d4edda;
        }

        .status-menunggu {
            background-color: #fff3cd;
        }

        .status-ditolak {
            background-color: #f8d7da;
        }

        .summary-item {
            margin: 5px 0;
            font-size: 10px;
        }
    </style>
</head>

<body>
    {{-- COVER PAGE --}}
    <div class="cover-page">
        <h1>LAPORAN TAHUNAN</h1>
        <h2>SISTEM INVENTARIS BARANG</h2>
        <p style="margin-top: 50px;">Tahun {{ $year }}</p>
        <p>Dicetak pada: {{ date('d F Y') }}</p>
    </div>

    {{-- LAPORAN PEMINJAMAN --}}
    @hasrole('admin')
        <div class="section-break">
            <div class="header">
                <h2>LAPORAN PEMINJAMAN BARANG</h2>
                <p>Periode: Tahun {{ $year }}</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="4%">No</th>
                        <th width="10%">Tanggal Pinjam</th>
                        <th width="14%">Nama Peminjam</th>
                        <th width="18%">Nama Barang</th>
                        <th width="15%">Jenis Barang</th>
                        <th width="11%">Kode Barang</th>
                        <th width="9%">Status</th>
                        <th width="10%">Tgl Kembali</th>
                        <th width="9%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse($peminjaman as $item)
                        @foreach ($item->peminjamanBarang as $barang)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $item->tanggal_peminjaman->format('d/m/Y') }}</td>
                                <td>{{ $item->nama_peminjam }}</td>
                                <td>{{ $barang->barang->nama_barang ?? '-' }}</td>
                                <td>{{ $barang->barang->jenisBarang->jenis ?? '-' }}</td>
                                <td class="text-center">
                                    {{ $barang->barang->kode_barang ? $barang->barang->jenisBarang->kode_utama . '' . $barang->barang->kode_barang : '-' }}
                                </td>
                                <td class="text-center">{{ ucfirst($barang->status) }}</td>
                                <td class="text-center">
                                    {{ $item->tanggal_pengembalian ? $item->tanggal_pengembalian->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $barang->catatan ?? ($item->keterangan ?? '-') }}</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="footer">
                <p><strong>Total Peminjaman: {{ $peminjaman->count() }} transaksi</strong></p>
            </div>
        </div>
    @endhasrole

    @hasanyrole('bendahara|kepala_sekolah')
        {{-- LAPORAN BARANG MASUK --}}
        <div class="section-break">
            <div class="header">
                <h2>LAPORAN BARANG MASUK</h2>
                <p>Periode: Tahun {{ $year }}</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="3%">No</th>
                        <th width="8%">Tanggal</th>
                        <th width="9%">Kategori</th>
                        <th width="12%">Supplier</th>
                        <th width="13%">Jenis Barang</th>
                        <th width="9%">Kode Barang</th>
                        <th width="15%">Nama Barang</th>
                        <th width="5%">Satuan</th>
                        <th width="11%">Harga Satuan</th>
                        <th width="10%">Subtotal</th>
                        <th width="11%">Total Harga</th>
                        <th width="15%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                        $grandTotal = 0;
                        $totalItems = 0;
                    @endphp
                    @forelse($barangMasuk as $item)
                        @php
                            $grandTotal += $item->total_harga;
                            $isFirstRow = true;
                            $isFirstDetail = true;
                        @endphp
                        @foreach ($item->details as $detail)
                            @php
                                $barangItems = $detail->barangItems;
                                $isFirstItemInDetail = true;
                            @endphp

                            @if ($barangItems->isEmpty())
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td>{{ $isFirstRow ? $item->tanggal->format('d/m/Y') : '' }}</td>
                                    <td>{{ $isFirstRow ? ucfirst($item->kategori) : '' }}</td>
                                    <td>{{ $isFirstRow ? $item->nama_supplier : '' }}</td>
                                    <td>{{ $detail->jenisBarang->jenis ?? '-' }}</td>
                                    <td class="text-center">-</td>
                                    <td>-</td>
                                    <td class="text-center">{{ $detail->jenisBarang->satuan ?? '-' }}</td>
                                    <td class="text-right">Rp {{ number_format($detail->harga_satuan ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right">Rp
                                        {{ number_format($detail->harga_satuan * $detail->jumlah, 0, ',', '.') }}</td>
                                    <td class="text-right">
                                        {{ $isFirstRow ? 'Rp ' . number_format($item->total_harga, 0, ',', '.') : '' }}
                                    </td>
                                    <td>{{ $detail->keterangan ?? ($item->keterangan ?? '-') }}</td>
                                </tr>
                                @php
                                    $totalItems++;
                                    $isFirstRow = false;
                                    $isFirstDetail = false;
                                @endphp
                            @else
                                @foreach ($barangItems as $barang)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>{{ $isFirstRow ? $item->tanggal->format('d/m/Y') : '' }}</td>
                                        <td>{{ $isFirstRow ? ucfirst($item->kategori) : '' }}</td>
                                        <td>{{ $isFirstRow ? $item->nama_supplier : '' }}</td>
                                        <td>{{ $isFirstItemInDetail ? $detail->jenisBarang->jenis ?? '-' : '' }}</td>
                                        <td class="text-center">
                                            {{ $barang->kode_barang ? $detail->jenisBarang->kode_utama . $barang->kode_barang : '-' }}
                                        </td>
                                        <td>{{ $barang->nama_barang ?? '-' }}</td>
                                        <td class="text-center">
                                            {{ $isFirstItemInDetail ? $detail->jenisBarang->satuan ?? '-' : '' }}</td>
                                        <td class="text-right">
                                            {{ $isFirstItemInDetail ? 'Rp ' . number_format($detail->harga_satuan ?? 0, 0, ',', '.') : '' }}
                                        </td>
                                        <td class="text-right">
                                            {{ $isFirstItemInDetail ? 'Rp ' . number_format($detail->harga_satuan * $detail->jumlah, 0, ',', '.') : '' }}
                                        </td>
                                        <td class="text-right">
                                            {{ $isFirstRow ? 'Rp ' . number_format($item->total_harga, 0, ',', '.') : '' }}
                                        </td>
                                        <td>{{ $detail->keterangan ?? ($item->keterangan ?? '-') }}</td>
                                    </tr>
                                    @php
                                        $totalItems++;
                                        $isFirstRow = false;
                                        $isFirstDetail = false;
                                        $isFirstItemInDetail = false;
                                    @endphp
                                @endforeach
                            @endif
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="12" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse

                    @if ($barangMasuk->count() > 0)
                        <tr style="background-color: #f8f8f8;">
                            <td colspan="7" class="text-right"><strong>TOTAL ITEM:</strong></td>
                            <td class="text-center"><strong>{{ $totalItems }}</strong></td>
                            <td colspan="2" class="text-right"><strong>TOTAL KESELURUHAN:</strong></td>
                            <td class="text-right"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                            <td></td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="footer">
                <p><strong>Total Data: {{ $totalItems }} item dari {{ $barangMasuk->count() }} transaksi</strong></p>
            </div>
        </div>

        {{-- LAPORAN BARANG KELUAR --}}
        <div class="section-break">
            <div class="header">
                <h2>LAPORAN BARANG KELUAR</h2>
                <p>Periode: Tahun {{ $year }}</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="12%">Tanggal</th>
                        <th width="18%">Jenis Barang</th>
                        <th width="13%">Kategori</th>
                        <th width="18%">Nama Barang</th>
                        <th width="10%">Kode Barang</th>
                        <th width="8%">Jumlah</th>
                        <th width="13%">Penerima</th>
                        <th width="13%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse($barangKeluar as $item)
                        @if ($item->items->count() > 0)
                            @foreach ($item->items as $detail)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                                    <td>{{ $item->jenisBarang->jenis ?? '-' }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $item->kategori)) }}</td>
                                    <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                                    <td class="text-center">
                                        {{ $detail?->barang?->kode_barang ? $detail->barang->jenisBarang->kode_utama . '' . $detail->barang->kode_barang : '-' }}
                                    </td>
                                    <td class="text-center">{{ $item->jumlah }}</td>
                                    <td>{{ $item->penerima ?? '-' }}</td>
                                    <td>{{ $item->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $item->jenisBarang->jenis ?? '-' }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $item->kategori)) }}</td>
                                <td>-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">{{ $item->jumlah }}</td>
                                <td>{{ $item->penerima ?? '-' }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="footer">
                <p><strong>Total Barang Keluar: {{ $barangKeluar->count() }} transaksi</strong></p>
            </div>
        </div>

        {{-- LAPORAN PENGAJUAN --}}
        <div class="section-break">
            <div class="header">
                <h2>LAPORAN PENGAJUAN</h2>
                <p>Periode: Tahun {{ $year }}</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="4%">No</th>
                        <th width="9%">Tanggal</th>
                        <th width="8%">Tipe</th>
                        <th width="13%">Jenis/Nama Barang</th>
                        <th width="15%">Item Perbaikan</th>
                        <th width="6%">Jml</th>
                        <th width="10%">Est. Biaya</th>
                        <th width="8%">Status</th>
                        <th width="14%">Alasan</th>
                        <th width="13%">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                        $totalBiaya = 0;
                    @endphp
                    @forelse($pengajuan as $item)
                        @php $totalBiaya += $item->estimasi_biaya; @endphp
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                            <td>{{ ucfirst($item->tipe) }}</td>
                            <td>
                                @if ($item->jenisBarang)
                                    {{ $item->jenisBarang->jenis }}
                                @else
                                    {{ $item->nama_barang ?? '-' }}
                                @endif
                            </td>
                            <td>
                                @if ($item->tipe === 'perbaikan' && $item->perbaikanItems->count() > 0)
                                    @foreach ($item->perbaikanItems as $perbaikan)
                                        {{ $perbaikan->barang->nama_barang ?? '-' }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">{{ $item->jumlah }}</td>
                            <td class="text-right">{{ number_format($item->estimasi_biaya, 0, ',', '.') }}</td>
                            <td class="text-center status-{{ $item->status }}">{{ ucfirst($item->status) }}</td>
                            <td>{{ Str::limit($item->alasan, 50) }}</td>
                            <td>{{ $item->catatan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse

                    @if ($pengajuan->count() > 0)
                        <tr style="background-color: #f8f8f8;">
                            <td colspan="6" class="text-right"><strong>TOTAL ESTIMASI BIAYA:</strong></td>
                            <td class="text-right"><strong>Rp {{ number_format($totalBiaya, 0, ',', '.') }}</strong></td>
                            <td colspan="3"></td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="footer">
                <p><strong>Total Pengajuan: {{ $pengajuan->count() }} pengajuan</strong></p>
            </div>
        </div>
    @endhasanyrole

    {{-- FOOTER AKHIR DOKUMEN --}}
    <div style="margin-top: 30px; text-align: center; font-size: 10px;">
        <p><strong>--- AKHIR LAPORAN TAHUNAN {{ $year }} ---</strong></p>
        <p>Dokumen ini dicetak pada: {{ date('d F Y') }}</p>
    </div>
</body>

</html>
