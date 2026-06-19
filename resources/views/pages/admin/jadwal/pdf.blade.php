<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Jadwal Polisi Hutan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
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
    </style>
</head>

<body>

    <div class="title">JADWAL POLISI HUTAN</div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="15%">Nama Pegawai</th>
                <th width="10%">Jabatan</th>
                <th width="8%">Hari</th>
                <th width="12%">Tanggal</th>
                <th width="8%">Waktu</th>
                <th width="24%">Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwal as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->pegawai->user->name ?? '-' }}</td>
                <td>{{ $item->pegawai->jabatan ?? '-' }}</td>
                <td>{{ $item->hari }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $item->waktu }}</td>
                <td>{{ $item->kegiatan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
