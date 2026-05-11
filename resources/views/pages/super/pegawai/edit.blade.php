@extends('layouts.master')
@section('content')
<style>
    /* Header Card */
    .card-header-custom {
        background-color: #06923E;
        color: #fff;
        border: none;
    }

    /* Button Simpan */
    .btn-simpan {
        background-color: #06923E;
        color: #fff;
        border: none;
    }

    .btn-simpan:hover {
        background-color: #2aa15a;
        color: #fff;
    }

    /* Button Batal */
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
                <h5 class="mb-0 text-white">Edit Data Pegawai</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="user_id" class="form-label">Pilih User</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ $pegawai->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ $pegawai->user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="super" {{ $pegawai->user->role == 'super' ? 'selected' : '' }}>Super Admin</option>
                            <option value="user" {{ $pegawai->user->role == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" name="nip" id="nip" class="form-control"
                            value="{{ $pegawai->nip }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan" class="form-control"
                            value="{{ $pegawai->jabatan }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3" class="form-control" required>{{ $pegawai->alamat }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-simpan">Update</button>
                    <a href="{{ route('pegawai.index') }}" class="btn btn-batal">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection