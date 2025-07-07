@extends('layouts.master') @section('title', 'Daftar Pengajuan') @section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pengajuan</h5>
        <a href="{{ route('dosen.pengajuan.create') }}" class="btn btn-primary">+ Buat Pengajuan</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        @if ($pengajuans->where('status', 'berkas_tidak_sesuai')->count() > 0)
            <div class="alert alert-warning">
                <strong>⚠️ Beberapa pengajuan Anda perlu diperbaiki.</strong><br>
                Silakan klik tombol <strong>Upload Berkas</strong> pada pengajuan yang diminta perbaikan.
                Lihat catatan admin di halaman upload berkas.
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Jenis</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuans as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->jenisProgram->nama }}</td>
                        <td>{{ $item->tanggal_mulai }} s.d. {{ $item->tanggal_selesai }}</td>
                        <td>
                            @php
                                $badgeColor = match($item->status) {
                                    'diajukan' => 'warning',
                                    'diterima' => 'success',
                                    'berkas_tidak_sesuai' => 'danger',
                                    'terverifikasi' => 'info',
                                    'invoice_diterbitkan' => 'primary',
                                    'menunggu_verifikasi_pembayaran' => 'secondary',
                                    'selesai' => 'success',
                                    'ditolak' => 'danger',
                                    default => 'dark'
                                };

                                $statusText = match($item->status) {
                                    'berkas_tidak_sesuai' => 'Berkas Tidak Sesuai',
                                    'invoice_diterbitkan' => 'Invoice Diterbitkan',
                                    'menunggu_verifikasi_pembayaran' => 'Menunggu Verifikasi Pembayaran',
                                    default => ucwords(str_replace('_', ' ', $item->status))
                                };
                            @endphp

                            <span class="badge bg-{{ $badgeColor }}">{{ $statusText }}</span>
                        </td>
                        <td style="max-width: 220px;">
                            <div class="d-flex flex-wrap gap-1">
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}">Lihat</button>

                            @if ($item->status === 'diterima')
                                <button class="btn btn-sm btn-secondary" disabled>Edit</button>
                            @else
                                <a href="{{ route('dosen.pengajuan.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            @endif

                            @if ($item->status == 'diterima')
                                <a href="{{ route('dosen.pengajuan.berkas', $item->id) }}" class="btn btn-sm btn-warning">
                                Upload Berkas
                                </a>
                            @elseif ($item->status == 'berkas_tidak_sesuai')
                                <a href="{{ route('dosen.pengajuan.berkas', $item->id) }}" class="btn btn-sm btn-danger">
                                Perbaiki Berkas
                                </a>
                            @elseif ($item->status == 'diajukan')
                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                            @elseif ($item->status == 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif

                            @if ($item->invoice)
                                <a href="{{ route('dosen.invoice.show', $item->id) }}" class="btn btn-sm btn-primary">
                                    💳 Lihat Invoice
                                </a>
                            @endif
                            </div>
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Pengajuan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Jenis Program:</strong> {{ $item->jenisProgram->nama }}</p>
                                <p><strong>Program Studi:</strong> {{ $item->program_studi }}</p>
                                <p><strong>Tanggal:</strong> {{ $item->tanggal_mulai }} s/d {{ $item->tanggal_selesai }}</p>
                                <p><strong>Status:</strong> {{ $item->status }}</p>
                                <p><strong>Mahasiswa:</strong></p>
                                <ul>
                                @foreach($item->mahasiswas as $mhs)
                                    <li>{{ $mhs->nama }} ({{ $mhs->nim }})</li>
                                @endforeach
                                </ul>
                            </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
