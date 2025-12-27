<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Barang Keluar</title>
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
        <h2>LAPORAN BARANG KELUAR</h2>
        <p>
            Periode: {{ date('d/m/Y', strtotime($filters['start_date'])) }} -
            {{ date('d/m/Y', strtotime($filters['end_date'])) }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th width="18%">Jenis Barang</th>
                <th width="13%">Kategori</th>
                <th width="18%">Nama Barang</th>
                <th width="8%">Kode Barang</th>
                <th width="13%">Penerima</th>
                <th width="13%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($data as $barangKeluar)
                @if ($barangKeluar->items->count() > 0)
                    @foreach ($barangKeluar->items as $item)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $barangKeluar->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $barangKeluar->jenisBarang->jenis ?? '-' }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $barangKeluar->kategori)) }}</td>
                            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td>
                                {{ $item?->barang?->kode_barang ? $item->barang->jenisBarang->kode_utama . '' . $item->barang->kode_barang : '-' }}
                            </td>
                            <td>{{ $barangKeluar->penerima ?? '-' }}</td>
                            <td>{{ $barangKeluar->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $barangKeluar->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $barangKeluar->jenisBarang->jenis ?? '-' }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $barangKeluar->kategori)) }}</td>
                        <td>-</td>
                        <td class="text-center">{{ $barangKeluar->jumlah }}</td>
                        <td>{{ $barangKeluar->penerima ?? '-' }}</td>
                        <td>{{ $barangKeluar->keterangan ?? '-' }}</td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y') }}</p>
    </div>
</body>

</html>
