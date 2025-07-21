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
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporans as $laporan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $laporan->pegawai->nama }}</td>
                    <td>{{ $laporan->pelatihan->nama }}</td>
                    <td>
                        <span class="badge bg-{{ $laporan->status == 'disetujui' ? 'success' : ($laporan->status == 'revisi' ? 'danger' : 'secondary') }}">
                            {{ ucfirst($laporan->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('manajer.laporan.show', $laporan->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
