@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">Kelola Petak</h5>
                <p class="text-muted mb-4">Pilih RPH untuk mengelola daftar petak</p>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>No</th>
                                <th>BKPH</th>
                                <th>Sektor RPH</th>
                                <th>Polhut</th>
                                <th>Jumlah Petak</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rph as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->bkph->daerah_bkph ?? '-' }}</td>
                                <td>{{ $item->sektor }}</td>
                                <td>{{ $item->pegawai->user->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $item->petak->count() }} petak</span>
                                </td>
                                <td>
                                    <a href="{{ route('adminpetak.index', $item->id) }}" class="btn btn-sm btn-primary">
                                        <i class="ti ti-settings me-1"></i>Kelola
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">Belum ada data RPH</div>
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
