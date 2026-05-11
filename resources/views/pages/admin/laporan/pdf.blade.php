<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .nama {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
            padding: 6px;
        }

        td {
            padding: 5px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .ttd-img {
            width: 80px;
            height: 20px;
            object-fit: contain;
        }
    </style>
</head>

<body>

    <div class="title">LAPORAN KEGIATAN</div>

    <div class="nama">
        <strong>Nama:</strong> {{ $namaPembuat }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="8%">Tanggal</th>
                <th width="7%">Waktu</th>
                <th width="10%">RPH</th>
                <th width="8%">Petak</th>
                <th width="25%">Uraian Kegiatan</th>
                <th width="12%">Saksi</th>
                <th width="8%">Status</th>
                <th width="9%">TTD</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $item->waktu }}</td>
                <td>{{ $item->sektor }}</td>

                {{-- PETAK HUTAN --}}
                <td>{{ $item->petak_hutan ?? '-' }}</td>

                {{-- URAIAN --}}
                <td>{{ $item->uraian_kegiatan }}</td>

                {{-- SAKSI --}}
                <td>{{ $item->saksi }}</td>

                {{-- STATUS --}}
                <td class="text-center">{{ ucfirst($item->status) }}</td>

                {{-- TANDA TANGAN --}}
                <td class="text-center">
                    @if($item->tanda_tangan)
                    <img src="{{ public_path('storage/'.$item->tanda_tangan) }}"
                        class="ttd-img">
                    @else
                    -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>