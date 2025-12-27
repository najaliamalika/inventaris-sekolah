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
                <th width="5%">No</th>
                <th width="12%">Tanggal Pinjam</th>
                <th width="15%">Nama Peminjam</th>
                <th width="20%">Nama Barang</th>
                <th width="15%">Jenis Barang</th>
                <th width="10%">Status</th>
                <th width="12%">Tgl Kembali</th>
                <th width="11%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($data as $peminjaman)
                @foreach ($peminjaman->peminjamanBarang as $item)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $peminjaman->tanggal_peminjaman->format('d/m/Y ') }}</td>
                        <td>{{ $peminjaman->nama_peminjam }}</td>
                        <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $item->barang->jenisBarang->jenis ?? '-' }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                        <td>{{ $peminjaman->tanggal_pengembalian ? $peminjaman->tanggal_pengembalian->format('d/m/Y') : '-' }}
                        </td>
                        <td>{{ $item->catatan ?? ($peminjaman->keterangan ?? '-') }}</td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y ') }}</p>
    </div>
</body>

</html>
