@extends('layouts.master')
@section('content')
<style>
    .card-header-custom {
        background-color: #06923E;
        color: #fff;
        border: none;
    }

    .btn-simpan {
        background-color: #06923E;
        color: #fff;
        border: none;
    }

    .btn-simpan:hover {
        background-color: #2aa15a;
        color: #fff;
    }

    .btn-batal {
        border: 2px solid #06923E;
        color: #06923E;
        background-color: transparent;
    }

    .btn-batal:hover {
        background-color: #f8f9fa;
        color: #2aa15a;
        border-color: #2aa15a;
    }
</style>

<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100 shadow-sm">
            <div class="card-header card-header-custom">
                <h5 class="mb-0 text-white">Tambah Jadwal Pegawai</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('jadwal.store') }}" method="POST">
                    @csrf

                    {{-- Pegawai (Role User Only) --}}
                    <div class="mb-3">
                        <label for="pegawai_id" class="form-label">Pegawai</label>
                        <select name="pegawai_id" id="pegawai_id"
                            class="form-select @error('pegawai_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach ($pegawai as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->nip }} - {{ $p->user->name }} ({{ $p->jabatan }})
                                </option>
                            @endforeach
                        </select>
                        @error('pegawai_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    {{-- Hari --}}
                    <div class="mb-3">
                        <label for="hari" class="form-label">Hari</label>
                        <input type="text" name="hari" id="hari"
                            class="form-control @error('hari') is-invalid @enderror" required>
                        @error('hari') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal"
                            class="form-control @error('tanggal') is-invalid @enderror" required>
                        @error('tanggal') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    {{-- Waktu --}}
                    <div class="mb-3">
                        <label for="waktu" class="form-label">Waktu</label>
                        <input type="time" name="waktu" id="waktu"
                            class="form-control @error('waktu') is-invalid @enderror" required>
                        @error('waktu') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    {{-- Kegiatan --}}
                    <div class="mb-3">
                        <label for="kegiatan" class="form-label">Kegiatan</label>
                        <textarea name="kegiatan" id="kegiatan" rows="3"
                            class="form-control @error('kegiatan') is-invalid @enderror" required></textarea>
                        @error('kegiatan') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-simpan">Simpan</button>
                    <a href="{{ route('jadwal.index') }}" class="btn btn-batal">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
