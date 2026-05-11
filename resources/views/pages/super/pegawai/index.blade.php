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
                    <h5 class="card-title fw-semibold mb-0">Data Pegawai</h5>
                    <a href="{{ route('pegawai.create') }}" class="btn btn-tambah">
                        <i class="ti ti-plus"></i> Tambah Data Pegawai
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Role</th>
                            <th>NIP</th>
                            <th>Jabatan</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($pegawai as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->user->role ?? '-' }}</td>
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item->jabatan }}</td>
                                <td>{{ $item->user->email }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td><a href="{{ route('pegawai.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('pegawai.delete', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data?')">Hapus</button>
                                    </form></td>
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