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
                    <h5 class="card-title fw-semibold mb-0">Data Jadwal</h5>
                    <a href="{{ route('jadwal.create') }}" class="btn btn-tambah">
                        <i class="ti ti-plus"></i> Tambah Jadwal
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>Hari</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Uraian Kegiatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwal as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $item->pegawai->user->name ?? '-' }}</strong><br>
                                    Jabatan: {{ $item->pegawai->jabatan ?? '-' }}<br>
                                    No HP: {{ $item->pegawai->rph->no_telp ?? '-' }}
                                </td>
                                <td>{{ $item->hari }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $item->waktu }}</td>
                                <td>{{ $item->kegiatan }}</td>
                                <td>
                                    <a href="{{ route('jadwal.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('jadwal.delete', $item->id) }}"
                                        method="POST"
                                        style="display:inline-block;"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    Data jadwal belum tersedia
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection