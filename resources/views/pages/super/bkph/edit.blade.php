@extends('layouts.master')
@section('content')
<style>
    .card-header-custom { background-color: #06923E; color: #fff; border: none; }
    .btn-simpan { background-color: #06923E; color: #fff; border: none; }
    .btn-simpan:hover { background-color: #2aa15a; color: #fff; }
    .btn-batal { border: 2px solid #06923E; color: #06923E; background-color: transparent; }
    .btn-batal:hover { background-color: #f8f9fa; color: #2aa15a; border-color: #2aa15a; }
</style>

<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100 shadow-sm">
            <div class="card-header card-header-custom">
                <h5 class="mb-0 text-white">Edit Data BKPH {{ $daerah }}</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('bkph.update', ['daerah' => strtolower($daerah), 'id' => $bkph->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="daerah_bkph" class="form-label">Daerah BKPH</label>
                        <input type="text" name="daerah_bkph" id="daerah_bkph"
                            class="form-control @error('daerah_bkph') is-invalid @enderror"
                            value="{{ $bkph->daerah_bkph }}" required>
                        @error('daerah_bkph') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_rph" class="form-label">Nama RPH</label>
                        <input type="text" name="nama_rph" id="nama_rph"
                            class="form-control @error('nama_rph') is-invalid @enderror"
                            value="{{ $bkph->nama_rph }}" required>
                        @error('nama_rph') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pegawai_id" class="form-label">Pegawai</label>
                        <select name="pegawai_id" id="pegawai_id"
                            class="form-select @error('pegawai_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach ($pegawai as $item)
                            <option value="{{ $item->id }}" {{ $bkph->pegawai_id == $item->id ? 'selected' : '' }}>
                                {{ $item->user->name ?? 'Pegawai '.$item->id }}
                            </option>
                            @endforeach
                        </select>
                        @error('pegawai_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_polhuter" class="form-label">Jumlah Polhuter</label>
                        <input type="text" name="jumlah_polhuter" id="jumlah_polhuter"
                            class="form-control @error('jumlah_polhuter') is-invalid @enderror"
                            value="{{ $bkph->jumlah_polhuter }}" required>
                        @error('jumlah_polhuter') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="telp_kantor" class="form-label">Telp Kantor</label>
                        <input type="text" name="telp_kantor" id="telp_kantor"
                            class="form-control @error('telp_kantor') is-invalid @enderror"
                            value="{{ $bkph->telp_kantor }}" required>
                        @error('telp_kantor') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-simpan">Update</button>
                    <a href="{{ route('bkph' . strtolower($daerah) . '.index') }}" class="btn btn-batal">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
