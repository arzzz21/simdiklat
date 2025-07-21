@extends('layouts.master')
@section('title', 'Verifikasi Laporan Pelatihan')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Daftar Laporan Pegawai Unit Anda</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pegawai</th>
                    <th>Pelatihan</th>
                    <th>Berkas Laporan</th>
                    <th>Status</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporans as $laporan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $laporan->pegawai->nama }}</td>
                    <td>
                        {{ $laporan->pelatihan->nama }}<br>
                        <small><strong>Tempat : </strong>{{ $laporan->pelatihan->tempat }}</small><br>
                        <small><strong>Waktu : </strong>{{ $laporan->pelatihan->tanggal_mulai }} s/d {{ $laporan->pelatihan->tanggal_selesai }}</small><br>
                    </td>
                    <td>
                        @if ($laporan)
                            <a href="{{ asset('storage/'.$laporan->file_laporan) }}"target="_blank" class="btn btn-sm btn-info">File Laporan</a><br>
                            <a href="{{ asset('storage/'.$laporan->file_surat_tugas) }}"target="_blank" class="btn btn-sm btn-warning">File Surat Tugas</a>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $laporan->status == 'disetujui' ? 'success' : ($laporan->status == 'revisi' ? 'danger' : 'secondary') }}">
                            {{ ucfirst($laporan->status) }}
                        </span>
                    </td>
                    <td>
                        @if ($laporan->status === "disetujui")
                            <span>Sudah Diverifikasi</span>
                        @else
                            <a href="{{ route('manajer.laporan.show', $laporan->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
