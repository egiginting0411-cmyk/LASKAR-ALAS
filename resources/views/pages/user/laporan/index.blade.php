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

    .wrap-text {
        max-width: 250px;
        white-space: normal;
        word-wrap: break-word;
    }
</style>
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">Laporan</h5>
                    <!-- Tombol Tambah -->
                    <a href="{{route('laporan.create')}}" class="btn btn-tambah">
                        <i class="ti ti-plus"></i> Tambah Data
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>RPH</th>
                                <th>Petak</th>
                                <th>Uraian Kegiatan</th>
                                <th>Saksi</th>
                                <th>Dokumentasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($laporan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->waktu }}</td>
                                <td>{{ $item->sektor }}</td>
                                <td>{{ $item->petak_hutan ?? '-' }}</td>
                                <td class="wrap-text">
                                    {{ Str::limit($item->uraian_kegiatan, 50) }}
                                </td>

                                {{-- SAKSI + TANDA TANGAN --}}
                                <td>
                                    <div>{{ $item->saksi }}</div>

                                    @if ($item->tanda_tangan)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/'.$item->tanda_tangan) }}"
                                            alt="Tanda Tangan"
                                            width="100"
                                            style="border:1px solid #ccc; border-radius:4px; cursor:pointer;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#previewModal"
                                            onclick="previewImage('{{ asset('storage/'.$item->tanda_tangan) }}')">
                                    </div>
                                    @endif
                                </td>

                                {{-- DOKUMENTASI --}}
                                <td>
                                    @if ($item->dokumentasi)
                                    <img src="{{ asset('storage/'.$item->dokumentasi) }}"
                                        alt="Dokumentasi"
                                        width="80"
                                        height="80"
                                        style="object-fit: cover; border-radius: 6px; cursor:pointer;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#previewModal"
                                        onclick="previewImage('{{ asset('storage/'.$item->dokumentasi) }}')">
                                    @else
                                    -
                                    @endif
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    @if (Str::lower($item->status) === 'proses')
                                    <span class="badge bg-warning">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                    @elseif (Str::lower($item->status) === 'divalidasi')
                                    <span class="badge bg-success">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                    @else
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($item->status ?? 'Unknown') }}
                                    </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <a href="{{ route('laporan.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('laporan.delete', $item->id) }}"
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
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    Belum ada data laporan
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
<!-- Modal Preview -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="previewImage" src="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(src) {
        document.getElementById('previewImage').src = src;
    }
</script>

@endsection