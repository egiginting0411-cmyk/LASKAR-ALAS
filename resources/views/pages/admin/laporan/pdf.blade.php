<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Kegiatan - {{ $namaPembuat }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            color: #000;
            background: #f5f5f5;
        }

        .page {
            width: 297mm;
            min-height: 210mm;
            margin: 20px auto;
            padding: 20mm 15mm;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* Header / Kop Surat */
        .header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px double #000;
        }

        .header .logo-placeholder {
            flex-shrink: 0;
            width: 70px;
            height: 70px;
        }

        .header .header-text {
            flex: 1;
        }

        .header .header-text .instansi {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header .alamat {
            font-size: 11px;
            color: #333;
            margin-top: 3px;
        }

        .header .telp {
            font-size: 10px;
            color: #555;
        }

        /* Judul Dokumen */
        .doc-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 20px 0 5px;
            text-decoration: underline;
        }

        .doc-subtitle {
            text-align: center;
            font-size: 12px;
            margin-bottom: 15px;
        }

        /* Info Pembuat */
        .info-row {
            margin-bottom: 10px;
            font-size: 12px;
        }

        /* Tabel Laporan */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background-color: #e8e8e8;
            text-align: center;
            padding: 6px 4px;
            font-weight: bold;
            font-size: 11px;
        }

        td {
            padding: 5px 4px;
            vertical-align: top;
            font-size: 11px;
        }

        .text-center {
            text-align: center;
        }

        .ttd-img {
            width: 80px;
            height: 40px;
            object-fit: contain;
        }

        /* Footer Tanda Tangan */
        .signature-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-box .label {
            font-size: 12px;
            margin-bottom: 5px;
        }

        .signature-box .placeholder {
            width: 150px;
            height: 60px;
            border: 1px dashed #999;
            margin: 0 auto 5px;
            line-height: 60px;
            color: #999;
            font-size: 10px;
        }

        .signature-box .name {
            font-size: 12px;
            font-weight: bold;
            text-decoration: underline;
        }

        .signature-box .nip {
            font-size: 10px;
            color: #333;
        }

        /* Tombol Print */
        .print-controls {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background: #f0f0f0;
            border-radius: 8px;
        }

        .btn-print {
            display: inline-block;
            padding: 12px 30px;
            background-color: #06923E;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-print:hover {
            background-color: #057a34;
        }

        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c757d;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            margin-left: 10px;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }

        .hint {
            font-size: 11px;
            color: #666;
            margin-top: 8px;
        }

        /* Print Styles */
        @media print {
            body {
                background: #fff;
            }

            .page {
                margin: 0;
                padding: 10mm 12mm;
                box-shadow: none;
                width: 100%;
                min-height: auto;
            }

            .print-controls {
                display: none !important;
            }

            @page {
                size: A4 landscape;
                margin: 0;
            }
        }
    </style>
</head>

<body>

    <div class="print-controls" id="printControls">
        <button class="btn-print" onclick="window.print()">
            &#128424; Save / Print
        </button>
        <a href="javascript:window.close()" class="btn-back">
            &#10006; Tutup
        </a>
        <div class="hint">Klik "Save / Print" untuk menyimpan sebagai PDF atau mencetak langsung</div>
    </div>

    <div class="page">

        <!-- Kop Surat / Header -->
        <div class="header">
            <div class="logo-placeholder">
                <img src="{{ asset('assets/images/logos/logo-1.jpg') }}" alt="Logo" style="width: 70px; height: 70px; object-fit: contain;">
            </div>
            <div class="header-text">
                <div class="instansi">KPH Banyuwangi {{ $kph['nama'] ?? ($daerah ?? '') }}</div>
                @if($kph)
                <div class="alamat">{{ $kph['alamat'] }}</div>
                <div class="telp">Telp: {{ $kph['telepon'] }} | Fax: {{ $kph['fax'] }}</div>
                <div class="telp">Email: {{ $kph['email'] }}</div>
                @else
                <div class="alamat">-</div>
                <div class="telp">Telp: - | Fax: -</div>
                <div class="telp">Email: -</div>
                @endif
            </div>
        </div>

        <!-- Judul Dokumen -->
        <div class="doc-title">Laporan Kegiatan Monitoring</div>

        <!-- Info -->
        <div class="info-row">
            <strong>Nama Pembuat:</strong> {{ $namaPembuat }}
        </div>

        <!-- Tabel Laporan -->
        <table>
            <thead>
                <tr>
                    <th width="3%">No</th>
                    <th width="8%">Tanggal</th>
                    <th width="6%">Waktu</th>
                    <th width="10%">RPH</th>
                    <th width="8%">Petak</th>
                    <th width="27%">Uraian Kegiatan</th>
                    <th width="12%">Saksi</th>
                    <th width="8%">Status</th>
                    <th width="10%">TTD</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td class="text-center">{{ $item->waktu }}</td>
                    <td>{{ $item->sektor }}</td>
                    <td>{{ $item->petak_hutan ?? '-' }}</td>
                    <td>{{ $item->uraian_kegiatan }}</td>
                    <td>{{ $item->saksi }}</td>
                    <td class="text-center">{{ ucfirst($item->status) }}</td>
                    <td class="text-center">
                        @if($item->tanda_tangan)
                        <img src="{{ asset('storage/'.$item->tanda_tangan) }}" class="ttd-img" alt="TTD">
                        @else
                        -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tanda Tangan -->
        <div class="signature-section">
            <div class="signature-box" style="text-align: left;">
                <div class="label">Mengetahui,</div>
                <div class="label" style="font-size: 11px;">Wakil Administratur / KSKPH</div>
                <div style="height: 60px;"></div>
                <div class="name">Sunardi</div>
                <div class="nip">NPK 171109057</div>
            </div>
        </div>

    </div>

</body>

</html>
