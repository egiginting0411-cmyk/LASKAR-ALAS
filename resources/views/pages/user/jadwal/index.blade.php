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

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">Jadwal Saya</h5>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>No</th>
                                <th>Hari</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Uraian Kegiatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwal as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->hari }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $item->waktu }}</td>
                                    <td>{{ $item->kegiatan }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        Jadwal belum tersedia
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
