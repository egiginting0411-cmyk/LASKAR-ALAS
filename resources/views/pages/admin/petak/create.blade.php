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
                <h5 class="mb-0 text-white">Tambah Petak</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="form-label">RPH</label>
                    <input type="text" class="form-control" value="{{ $rph->sektor }} ({{ $rph->bkph->daerah_bkph }})" disabled>
                </div>

                <form action="{{ route('adminpetak.store', $rph->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_petak" class="form-label">Nama Petak</label>
                        <input type="text" name="nama_petak" id="nama_petak"
                            class="form-control @error('nama_petak') is-invalid @enderror"
                            value="{{ old('nama_petak') }}" required placeholder="Contoh: Blok A-01">
                        @error('nama_petak')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-simpan">Simpan</button>
                    <a href="{{ route('adminpetak.index', $rph->id) }}" class="btn btn-batal">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
