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

    .btn-danger {
        background-color: #06923E;
        color: #fff;
        border: none;
    }

    .btn-danger:hover {
        background-color: #2aa15a;
        color: #fff;
    }
</style>
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">Laporan</h5>
                    <a href="{{ route('laporan.export', $rph->pegawai_id) }}"
                        class="btn btn-danger">
                        Export PDF
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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($laporan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $item->waktu }}</td>
                                <td>{{ $item->sektor }}</td>

                                {{-- PETAK HUTAN --}}
                                <td>{{ $item->petak_hutan ?? '-' }}</td>

                                {{-- URAIAN --}}
                                <td>{{ Str::limit($item->uraian_kegiatan, 50) }}</td>

                                {{-- SAKSI + TANDA TANGAN --}}
                                <td>
                                    <div>{{ $item->saksi }}</div>

                                    @if ($item->tanda_tangan)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/'.$item->tanda_tangan) }}"
                                            alt="Tanda Tangan"
                                            class="img-thumbnail"
                                            style="max-width:120px; cursor:pointer;"
                                            onclick="showImageModal('{{ asset('storage/'.$item->tanda_tangan) }}')">
                                    </div>
                                    @endif
                                </td>

                                {{-- DOKUMENTASI --}}
                                <td>
                                    @if ($item->dokumentasi)
                                    <img src="{{ asset('storage/'.$item->dokumentasi) }}"
                                        alt="Dokumentasi"
                                        class="img-thumbnail"
                                        style="max-width: 100px; max-height: 100px; object-fit: cover; cursor: pointer;"
                                        onclick="showImageModal('{{ asset('storage/'.$item->dokumentasi) }}')">
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    @if ($item->status === 'proses')
                                    <button class="btn btn-sm btn-warning btn-approve"
                                        data-id="{{ $item->id }}"
                                        title="Klik untuk validasi">
                                        <i class="fas fa-clock me-1"></i>Proses
                                    </button>
                                    @else
                                    <span class="btn btn-sm btn-success">
                                        <i class="fas fa-check me-1"></i>Divalidasi
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <br>Belum ada data laporan
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk preview gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Dokumentasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Dokumentasi" class="img-fluid">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle approve button clicks
        document.querySelectorAll('.btn-approve').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const laporanId = this.dataset.id;
                const btn = this;

                // Konfirmasi dengan SweetAlert
                Swal.fire({
                    title: 'Validasi Laporan',
                    text: "Apakah Anda yakin ingin memvalidasi laporan ini? Status akan berubah menjadi 'Divalidasi'.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#06923E',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-check me-1"></i>Ya, Validasi!',
                    cancelButtonText: '<i class="fas fa-times me-1"></i>Batal',
                    reverseButtons: true,
                    focusConfirm: false,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        approveReport(laporanId, btn);
                    }
                });
            });
        });

        // Function untuk approve laporan
        function approveReport(laporanId, btn) {
            btn.disabled = true;
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';

            // ✅ gunakan route() agar sesuai prefix /admin
            const url = "{{ route('laporan.approve', ':id') }}".replace(':id', laporanId);

            fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) throw response;
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const statusCell = btn.closest('td');
                        if (statusCell) {
                            statusCell.innerHTML = '<span class="badge bg-success fs-6"><i class="fas fa-check me-1"></i>Divalidasi</span>';
                        }
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message || 'Laporan berhasil divalidasi.',
                            icon: 'success',
                            confirmButtonColor: '#06923E',
                            timer: 3000,
                            timerProgressBar: true
                        });
                    } else {
                        throw new Error(data.message || 'Gagal memvalidasi laporan');
                    }
                })
                .catch(async (error) => {
                    console.error('Error:', error);
                    let errorMessage = 'Terjadi kesalahan saat memvalidasi laporan.';
                    try {
                        if (error instanceof Response) {
                            const errorData = await error.json();
                            errorMessage = errorData.message || errorMessage;
                            if (error.status === 419) {
                                errorMessage = 'Sesi Anda telah habis. Silakan refresh halaman dan coba lagi.';
                            }
                        }
                    } catch {}
                    Swal.fire({
                        title: 'Oops!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                });
        }

        // Function untuk show image modal
        window.showImageModal = function(imageSrc) {
            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            document.getElementById('modalImage').src = imageSrc;
            modal.show();
        };
    });
</script>
@endpush