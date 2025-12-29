<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Barang Masuk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
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
            margin-top: 20px;
            font-size: 9px;
        }

        .group-header {
            background-color: #e8e8e8;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN BARANG MASUK</h2>
        <p>
            Periode: {{ date('d/m/Y', strtotime($filters['start_date'])) }} -
            {{ date('d/m/Y', strtotime($filters['end_date'])) }}
        </p>
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
                <th width="15%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                $grandTotal = 0;
                $totalItems = 0;
            @endphp
            @forelse($data as $barangMasuk)
                @php
                    $grandTotal += $barangMasuk->total_harga;
                @endphp
                @foreach ($barangMasuk->details as $detail)
                    @php
                        $barangItems = $detail->barangItems;
                    @endphp

                    @if ($barangItems->isEmpty())
                        {{-- Jika tidak ada barang items, tampilkan data detail saja --}}
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $barangMasuk->tanggal->format('d/m/Y') }}</td>
                            <td>{{ ucfirst($barangMasuk->kategori) }}</td>
                            <td>{{ $barangMasuk->nama_supplier }}</td>
                            <td>{{ $detail->jenisBarang->jenis ?? '-' }}</td>
                            <td class="text-center">-</td>
                            <td>-</td>
                            <td class="text-center">{{ $detail->jenisBarang->satuan ?? '-' }}</td>
                            <td class="text-right">Rp {{ number_format($detail->harga_satuan ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $detail->keterangan ?? ($barangMasuk->keterangan ?? '-') }}</td>
                        </tr>
                        @php $totalItems++; @endphp
                    @else
                        {{-- Jika ada barang items, tampilkan setiap barang dengan semua kolom terisi --}}
                        @foreach ($barangItems as $barang)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $barangMasuk->tanggal->format('d/m/Y') }}</td>
                                <td>{{ ucfirst($barangMasuk->kategori) }}</td>
                                <td>{{ $barangMasuk->nama_supplier }}</td>
                                <td>{{ $detail->jenisBarang->jenis ?? '-' }}</td>
                                <td class="text-center">
                                    {{ $barang->kode_barang ? $barang->jenisBarang->kode_utama . $barang->kode_barang : '-' }}
                                </td>
                                <td>{{ $barang->nama_barang ?? '-' }}</td>
                                <td class="text-center">{{ $detail->jenisBarang->satuan ?? '-' }}</td>
                                <td class="text-right">Rp {{ number_format($detail->harga_satuan ?? 0, 0, ',', '.') }}
                                </td>
                                <td>{{ $detail->keterangan ?? ($barangMasuk->keterangan ?? '-') }}</td>
                            </tr>
                            @php $totalItems++; @endphp
                        @endforeach
                    @endif
                @endforeach
            @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse

            @if ($data->count() > 0)
                <tr style="background-color: #f8f8f8;">
                    <td colspan="6" class="text-right"><strong>TOTAL ITEM:</strong></td>
                    <td class="text-center"><strong>{{ $totalItems }}</strong></td>
                    <td colspan="2" class="text-right"><strong>TOTAL KESELURUHAN:</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
        <p style="margin-top: 5px;">Total Data: {{ $totalItems }} item dari {{ $data->count() }} transaksi</p>
    </div>
</body>

</html>
