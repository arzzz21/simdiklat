@extends('layouts.master')
@section('title', 'Dashboard Pegawai')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Selamat datang, {{ auth()->user()->name }}</h5>
        <p class="mb-0">Berikut pelatihan yang Anda ikuti:</p>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pelatihan</th>
                    <th>Tempat</th>
                    <th>Tanggal</th>
                    <th>Berkas Info</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pelatihans as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->tempat }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d-m-Y') }}</td>
                        <td>
                            @if ($p->file_info)
                                <a href="{{ asset('storage/' . $p->file_info) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if (now()->gt($p->tanggal_selesai))
                                <span class="badge bg-success">Sudah Selesai</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum Selesai</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pegawai.pelatihan.surat', $p->id) }}" class="btn btn-sm btn-success" target="_blank">
                                View Surat Tugas
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Belum ada pelatihan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
