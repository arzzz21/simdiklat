@extends('layouts.master')
@section('title', 'Daftar Pelatihan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Daftar Pelatihan</h5>
        <a href="{{ route('admin.pelatihan.create') }}" class="btn btn-primary">+ Tambah Pelatihan</a>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Tempat</th>
                    <th>Tanggal</th>
                    <th>Peserta</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pelatihans as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->tempat }}</td>
                    <td>{{ $item->tanggal_mulai }} s/d {{ $item->tanggal_selesai }}</td>
                    <td>
                        <ul class="mb-0">
                            @foreach ($item->peserta as $p)
                                <li>{{ $p->nama }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="{{ route('admin.pelatihan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.pelatihan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                        @if ($item->laporan)
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#laporanModal{{ $item->id }}">
                            Lihat Laporan
                        </button>
                        @endif
                    </td>
                </tr>

                {{-- MODAL (diletakkan di luar <tr>) --}}
                @if ($item->laporan)
                <div class="modal fade" id="laporanModal{{ $item->id }}" tabindex="-1" aria-labelledby="laporanModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="laporanModalLabel{{ $item->id }}">Detail Laporan Pelatihan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nama Pelatihan :</strong> {{ $item->laporan->pelatihan->nama }}</p>
                                <p><strong>Ringkasan Kegiatan :</strong> {{ $item->laporan->ringkasan }}</p>
                                <p><strong>Rencana Tindak Lanjut :</strong> </p>
                                <ul>
                                    @foreach ($item->laporan->rtl as $point)
                                        <li>{{ $point }}</li>
                                    @endforeach
                                </ul>
                                <p><strong>Laporan File :</strong>
                                    <a href="{{ asset('storage/' . $item->laporan->file_laporan) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        Lihat Laporan
                                    </a>
                                </p>
                                <p><strong>Surat Tugas TTD :</strong>
                                    <a href="{{ asset('storage/' . $item->laporan->file_surat_tugas) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        Lihat Surat
                                    </a>
                                </p>
                                <p><strong>Status :</strong> {{ ucfirst($item->laporan->status) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection

