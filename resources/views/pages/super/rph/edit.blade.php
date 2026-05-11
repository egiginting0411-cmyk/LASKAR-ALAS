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
                <h5 class="mb-0 text-white">Edit Data RPH</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('rph.update', [$bkph->id, $rph->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="pegawai_id" class="form-label">Pilih Pegawai</label>
                        <select name="pegawai_id" id="pegawai_id"
                            class="form-select @error('pegawai_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach ($pegawai as $pegawai)
                                <option value="{{ $pegawai->id }}"
                                    {{ $rph->pegawai_id == $pegawai->id ? 'selected' : '' }}>
                                    {{ $pegawai->user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('pegawai_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sektor" class="form-label">Sektor</label>
                        <input type="text" name="sektor" id="sektor"
                            value="{{ old('sektor', $rph->sektor) }}"
                            class="form-control @error('sektor') is-invalid @enderror" required>
                        @error('sektor') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_telp" class="form-label">No. Telp</label>
                        <input type="text" name="no_telp" id="no_telp"
                            value="{{ old('no_telp', $rph->no_telp) }}"
                            class="form-control @error('no_telp') is-invalid @enderror" required>
                        @error('no_telp') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-simpan">Update</button>
                    <a href="{{ route('rph.index', $bkph->id) }}" class="btn btn-batal">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
