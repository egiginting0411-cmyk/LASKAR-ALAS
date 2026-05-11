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
                <h5 class="mb-0 text-white">Tambah Laporan Monitoring</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Pegawai --}}
                    <input type="hidden" name="pegawai_id" value="{{ $laporan->pegawai->id }}">
                    <div class="mb-3">
                        <label class="form-label">Pegawai</label>
                        <input type="text" class="form-control" value="{{ $laporan->pegawai->user->name }}" disabled>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ $laporan->tanggal }}"
                                class="form-control @error('tanggal') is-invalid @enderror" required>
                            @error('tanggal') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="waktu" class="form-label">Waktu</label>
                            <input type="time" name="waktu" id="waktu" value="{{ $laporan->waktu }}"
                                class="form-control @error('waktu') is-invalid @enderror" required>
                            @error('waktu') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="sektor" class="form-label">RPH</label>
                        <input type="text" name="sektor" id="sektor" value="{{ $laporan->sektor }}"
                            class="form-control @error('sektor') is-invalid @enderror" required>
                        @error('sektor') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="petak_hutan" class="form-label">Petak Hutan</label>
                        <input type="text" name="petak_hutan" id="petak_hutan"
                            value="{{ $laporan->petak_hutan }}"
                            class="form-control @error('petak_hutan') is-invalid @enderror" required>
                        @error('petak_hutan')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="uraian_kegiatan" class="form-label">Uraian Kegiatan</label>
                        <textarea name="uraian_kegiatan" id="uraian_kegiatan" rows="3"
                            class="form-control @error('uraian_kegiatan') is-invalid @enderror" required>{{ $laporan->uraian_kegiatan }}</textarea>
                        @error('uraian_kegiatan') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="dokumentasi" class="form-label">Dokumentasi (Foto)</label>
                        @if($laporan->dokumentasi)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$laporan->dokumentasi) }}" alt="Dokumentasi"
                                style="max-width: 150px; max-height: 150px; object-fit: cover;">
                        </div>
                        @endif
                        <input type="file" name="dokumentasi" id="dokumentasi"
                            class="form-control @error('dokumentasi') is-invalid @enderror">
                        @error('dokumentasi') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="saksi" class="form-label">Saksi</label>
                        <select name="saksi" id="saksi" class="form-control @error('saksi') is-invalid @enderror" required>
                            <option value="">-- Pilih Saksi --</option>
                            @foreach ($user as $u)
                            <option value="{{ $u->name }}" {{ $laporan->saksi == $u->name ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('saksi') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanda Tangan</label>

                        {{-- Preview tanda tangan lama --}}
                        @if($laporan->tanda_tangan)
                        <div class="mb-2">
                            <p class="mb-1">Tanda tangan saat ini:</p>
                            <img src="{{ asset('storage/'.$laporan->tanda_tangan) }}"
                                style="max-width:250px; border:1px solid #ccc; padding:5px;">
                        </div>
                        @endif

                        <p class="mb-1 mt-2">Buat / Ubah Tanda Tangan:</p>

                        <div style="border:2px solid #06923E; border-radius:8px;">
                            <canvas id="signature-pad" width="600" height="200"
                                style="width:100%; height:200px;"></canvas>
                        </div>

                        <button type="button" class="btn btn-sm btn-danger mt-2" id="clear-signature">
                            Hapus Tanda Tangan Baru
                        </button>

                        <input type="hidden" name="tanda_tangan" id="tanda_tangan">

                        @error('tanda_tangan')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <button type="submit" class="btn btn-simpan">Simpan</button>
                    <a href="{{ route('laporan.index') }}" class="btn btn-batal">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const canvas = document.getElementById('signature-pad');
    const ctx = canvas.getContext('2d');
    let drawing = false;

    function getPosition(e) {
        const rect = canvas.getBoundingClientRect();
        return {
            x: (e.clientX || e.touches[0].clientX) - rect.left,
            y: (e.clientY || e.touches[0].clientY) - rect.top
        };
    }

    function startPosition(e) {
        drawing = true;
        draw(e);
    }

    function endPosition() {
        drawing = false;
        ctx.beginPath();
        saveSignature();
    }

    function draw(e) {
        if (!drawing) return;

        e.preventDefault();

        const pos = getPosition(e);

        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';

        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    }

    // Mouse
    canvas.addEventListener('mousedown', startPosition);
    canvas.addEventListener('mouseup', endPosition);
    canvas.addEventListener('mousemove', draw);

    // Touch
    canvas.addEventListener('touchstart', startPosition);
    canvas.addEventListener('touchend', endPosition);
    canvas.addEventListener('touchmove', draw);

    // Clear
    document.getElementById('clear-signature')
        .addEventListener('click', function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById('tanda_tangan').value = '';
        });

    function saveSignature() {
        const dataURL = canvas.toDataURL('image/png');
        document.getElementById('tanda_tangan').value = dataURL;
    }

    document.querySelector('form')
        .addEventListener('submit', function() {
            saveSignature();
        });
</script>
@endpush