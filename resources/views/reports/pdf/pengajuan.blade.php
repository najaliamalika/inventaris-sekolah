<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Pengajuan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
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
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
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

        .status-disetujui {
            background-color: #d4edda;
        }

        .status-menunggu {
            background-color: #fff3cd;
        }

        .status-ditolak {
            background-color: #f8d7da;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN PENGAJUAN</h2>
        <p>
            Periode: {{ date('d/m/Y', strtotime($filters['start_date'])) }} -
            {{ date('d/m/Y', strtotime($filters['end_date'])) }}

        </p>
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
            @forelse($data as $pengajuan)
                @php $totalBiaya += $pengajuan->estimasi_biaya; @endphp
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $pengajuan->tanggal->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($pengajuan->tipe) }}</td>
                    <td>
                        @if ($pengajuan->jenisBarang)
                            {{ $pengajuan->jenisBarang->jenis }}
                        @else
                            {{ $pengajuan->nama_barang ?? '-' }}
                        @endif
                    </td>
                    <td>
                        @if ($pengajuan->tipe === 'perbaikan' && $pengajuan->perbaikanItems->count() > 0)
                            @foreach ($pengajuan->perbaikanItems as $item)
                                {{ $item->barang->nama_barang ?? '-' }}@if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">{{ $pengajuan->jumlah }}</td>
                    <td class="text-right">{{ number_format($pengajuan->estimasi_biaya, 0, ',', '.') }}</td>
                    <td class="text-center status-{{ $pengajuan->status }}">{{ ucfirst($pengajuan->status) }}</td>
                    <td>{{ Str::limit($pengajuan->alasan, 50) }}</td>
                    <td>{{ $pengajuan->catatan ?? '-' }}</td>
                </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
                @if ($data->count() > 0)
                    <tr>
                        <td colspan="6" class="text-right"><strong>TOTAL ESTIMASI BIAYA:</strong></td>
                        <td class="text-right"><strong>Rp {{ number_format($totalBiaya, 0, ',', '.') }}</strong></td>
                        <td colspan="3"></td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="footer">
            <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
        </div>
    </body>

    </html>
