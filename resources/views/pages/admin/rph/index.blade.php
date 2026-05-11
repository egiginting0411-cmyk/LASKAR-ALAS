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

    .btn-disable {
        background-color: #6c757d;
        border: none;
        color: #fff;
    }

    .btn-disable:hover {
        background-color: #6c757d;
        color: #fff;
    }
</style>
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">RPH</h5>
                    <a href="{{ route('adminrph.create', ['bkph_id' => $bkph->id]) }}"
                        class="btn btn-tambah">
                        <i class="ti ti-plus"></i> Tambah Data
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>No</th>
                                <th>Nama Polhuter</th>
                                <th>NIP</th>
                                <th>Sektor</th>
                                <th>No. Telp</th>
                                <th>Laporan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rph as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->pegawai->user->name?? '-' }}</td>
                                <td>{{ $item->pegawai->nip ?? '-' }}</td>
                                <td>{{ $item->sektor }}</td>
                                <td>{{ $item->no_telp }}</td>
                                <td>
                                    <a href="{{ route('adminlaporan.index', $item->id) }}" class="btn btn-sm btn-info">
                                        Lihat Laporan
                                    </a>
                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('adminrph.edit', ['rph' => $item->id, 'bkph_id' => $bkph->id]) }}"
                                        class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('adminrph.delete', ['rph' => $item->id, 'bkph_id' => $bkph->id]) }}"
                                        method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus data?')">
                                            Hapus
                                        </button>
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