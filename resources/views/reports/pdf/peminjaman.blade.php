<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 5px 0;
        }

        .info {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN PEMINJAMAN BARANG</h2>
        <p>

            Periode: {{ date('d/m/Y', strtotime($filters['start_date'])) }} -
            {{ date('d/m/Y', strtotime($filters['end_date'])) }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="10%">Tanggal Pinjam</th>
                <th width="14%">Nama Peminjam</th>
                <th width="18%">Nama Barang</th>
                <th width="9%">Jenis Barang</th>
                <th width="6%">Jumlah</th>
                <th width="11%">Kode Barang</th>
                <th width="9%">Status</th>
                <th width="10%">Tgl Kembali</th>
                <th width="9%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                $totalBarangPeminjaman = 0;
            @endphp
            @forelse($data as $item)
                @foreach ($item->peminjamanBarang as $barang)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $item->tanggal_peminjaman->format('d/m/Y') }}</td>
                        <td>{{ $item->nama_peminjam }}</td>
                        <td>{{ $barang->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $barang->barang->jenisBarang->jenis ?? '-' }}</td>
                        <td class="text-center">
                            1
                        </td>
                        <td class="text-center">
                            {{ $barang->barang->kode_barang ? $barang->barang->jenisBarang->kode_utama . '' . $barang->barang->kode_barang : '-' }}
                        </td>
                        <td class="text-center">{{ ucfirst($barang->status) }}</td>
                        <td class="text-center">
                            {{ $item->tanggal_pengembalian ? $item->tanggal_pengembalian->format('d/m/Y') : '-' }}
                        </td>
                        <td>{{ $barang->catatan ?? ($item->keterangan ?? '-') }}</td>
                    </tr>
                    @php $totalBarangPeminjaman++ @endphp
                @endforeach
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
            <tr style="background-color: #f8f8f8;">
                <td colspan="9" class="text-right"><strong>TOTAL BARANG:</strong></td>
                <td class="text-center"><strong>{{ $totalBarangPeminjaman }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Total Peminjaman: {{ $data->count() }} transaksi</strong></p>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y ') }}</p>
    </div>
</body>

</html>
