@extends('layouts.master')

@section('content')
<style>
    /* Card Style */
    .card-custom {
        border: 1px solid #ddd;       /* outline */
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1); /* shading */
    }

    /* Table Header Custom */
    .table thead th {
        background-color: #06923E !important;
        color: #fff !important;
        text-align: center;
        vertical-align: middle;
    }
</style>

<div class="container mt-4">
    <div class="row">
        <!-- Card Total Pegawai -->
        <div class="col-md-4">
            <div class="card card-custom text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Pegawai</h5>
                    <h2>{{ $totalPegawai }}</h2>
                </div>
            </div>
        </div>

        <!-- Card Total BKPH -->
        <div class="col-md-4">
            <div class="card card-custom text-center">
                <div class="card-body">
                    <h5 class="card-title">Total BKPH</h5>
                    <h2>{{ $totalBkph }}</h2>
                </div>
            </div>
        </div>

        <!-- Card Total RPH -->
        <div class="col-md-4">
            <div class="card card-custom text-center">
                <div class="card-body">
                    <h5 class="card-title">Total RPH</h5>
                    <h2>{{ $totalRph }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Pegawai -->
    <div class="card card-custom mt-4">
        <div class="card-header" style="background-color:#06923E;">
            <h5 class="mb-0" style="color: #fff;">Data Pegawai (Terbaru)</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIP</th>
                        <th>Jabatan</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pegawai as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->nip }}</td>
                        <td>{{ $p->jabatan }}</td>
                        <td>{{ $p->alamat }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table BKPH -->
    <div class="card card-custom mt-4">
        <div class="card-header" style="background-color:#06923E;">
            <h5 class="mb-0" style="color: #fff;">Data BKPH (Terbaru)</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Daerah BKPH</th>
                        <th>Nama RPH</th>
                        <th>Jumlah Polhuter</th>
                        <th>Telp Kantor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bkph as $b)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $b->daerah_bkph }}</td>
                        <td>{{ $b->nama_rph }}</td>
                        <td>{{ $b->jumlah_polhuter }}</td>
                        <td>{{ $b->telp_kantor }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table RPH -->
    <div class="card card-custom mt-4">
        <div class="card-header" style="background-color:#06923E;">
            <h5 class="mb-0" style="color: #fff;">Data RPH (Terbaru)</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sektor</th>
                        <th>No Telp</th>
                        <th>Pegawai</th>
                        <th>BKPH</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rph as $r)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $r->sektor }}</td>
                        <td>{{ $r->no_telp }}</td>
                        <td>{{ $r->pegawai->nip ?? '-' }}</td>
                        <td>{{ $r->bkph->daerah_bkph ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
