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
                <h5 class="mb-0 text-white">Edit Jadwal Pegawai</h5>
            </div>
            <div class="card-body p-4">

                <form action="{{ route('jadwalbkph.update', $jadwal->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Pegawai --}}
                    <div class="mb-3">
                        <label class="form-label">Pegawai</label>
                        <select name="pegawai_id"
                            class="form-select @error('pegawai_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach ($pegawai as $p)
                                <option value="{{ $p->id }}"
                                    {{ $jadwal->pegawai_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->nip }} - {{ $p->user->name }} ({{ $p->jabatan }})
                                </option>
                            @endforeach
                        </select>
                        @error('pegawai_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    {{-- Hari --}}
                    <div class="mb-3">
                        <label class="form-label">Hari</label>
                        <input type="text" name="hari"
                            class="form-control @error('hari') is-invalid @enderror"
                            value="{{ $jadwal->hari }}" required>
                        @error('hari') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal"
                            class="form-control @error('tanggal') is-invalid @enderror"
                            value="{{ $jadwal->tanggal }}" required>
                        @error('tanggal') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    {{-- Waktu --}}
                    <div class="mb-3">
                        <label class="form-label">Waktu</label>
                        <input type="time" name="waktu"
                            class="form-control @error('waktu') is-invalid @enderror"
                            value="{{ $jadwal->waktu }}" required>
                        @error('waktu') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    {{-- Kegiatan --}}
                    <div class="mb-3">
                        <label class="form-label">Kegiatan</label>
                        <textarea name="kegiatan" rows="3"
                            class="form-control @error('kegiatan') is-invalid @enderror"
                            required>{{ $jadwal->kegiatan }}</textarea>
                        @error('kegiatan') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-simpan">Update</button>
                    <a href="{{ route('jadwalbkph.index') }}" class="btn btn-batal">Batal</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
