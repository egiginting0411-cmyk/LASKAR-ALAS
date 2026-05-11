@extends('layouts.master')
@section('content')
<style>
    .btn-tambah {
        background-color: #06923E;
        color: #fff;
        border: none;
    }

    .btn-tambah:hover {
        background-color: #2aa15a;
        color: #fff;
    }
</style>
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">BKPH Kalibaru</h5>
                    <a href="{{ route('bkph.create', ['daerah' => strtolower($daerah)]) }}" class="btn btn-tambah">
                        <i class="ti ti-plus"></i> Tambah Data
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <th>No</th>
                            <th>Nama RPH</th>
                            <th>Nama Asper</th>
                            <th>Jumlah Poluter</th>
                            <th>Telp Kantor</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($bkph as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_rph }}</td>
                                <td>{{ $item->pegawai->user->name }}</td>
                                <td>{{ $item->jumlah_polhuter }}</td>
                                <td>{{ $item->telp_kantor }}</td>
                                <td>
                                    <a href="{{ route('rph.index', $item->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                    <a href="{{ route('bkph.edit', ['daerah' => strtolower($daerah), 'id' => $item->id]) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('bkph.delete', ['daerah' => strtolower($daerah), 'id' => $item->id]) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection