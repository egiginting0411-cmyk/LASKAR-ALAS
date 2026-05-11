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
                        <h5 class="card-title fw-semibold mb-0">
                            BKPH {{ $daerah }}
                        </h5>

                        <a href="{{ route('adminbkph.create') }}" class="btn btn-tambah">
                            <i class="ti ti-plus"></i> Tambah Data
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th>No</th>
                                    <th>Nama RPH</th>
                                    <th>Nama Asper</th>
                                    <th>Jumlah Polhuter</th>
                                    <th>Telp Kantor</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($bkph as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_rph }}</td>
                                        <td>{{ optional($item->pegawai->user)->name ?? '-' }}</td>
                                        <td>{{ $item->jumlah_polhuter }}</td>
                                        <td>{{ $item->telp_kantor }}</td>
                                        <td>
                                            <a href="{{ route('adminrph.index', $item->id) }}" class="btn btn-sm btn-info">
                                                Lihat
                                            </a>
                                            <a href="{{ route('adminbkph.edit', $item->id) }}"
                                                class="btn btn-warning btn-sm">
                                                Edit
                                            </a>
                                            <form action="{{ route('adminbkph.delete', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            Data BKPH belum tersedia
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
