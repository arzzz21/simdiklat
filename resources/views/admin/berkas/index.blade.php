@extends('layouts.master')
@section('title', 'Verifikasi Berkas')

@section('content')

<div class="card">
    <div class="card-header">
        <h5>Verifikasi Berkas Mahasiswa</h5>
    </div>
    <div class="card-body"> @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Dosen</th>
                    <th>Program</th>
                    <th>Nama Berkas</th>
                    <th>Status</th>
                    <th>File</th>
                    <th>Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($berkas as $b)
                <tr>
                    <td>{{ $b->pengajuan->user->name }}</td>
                    <td>{{ $b->pengajuan->jenisProgram->nama }}</td>
                    <td>{{ $b->nama_berkas }}</td>
                    <td>
                        @if($b->status_verifikasi == 'valid')
                            <span class="badge bg-success">Valid</span>
                        @elseif($b->status_verifikasi == 'invalid')
                            <span class="badge bg-danger">Invalid</span>
                        @else
                            <span class="badge bg-warning">Menunggu</span>
                        @endif
                        @if($b->catatan)
                            <br><small>{{ $b->catatan }}</small>
                        @endif
                    </td>
                    <td>
                        <a href="{{ asset('storage/' . $b->file) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.berkas.verifikasi', $b->id) }}" method="POST">
                            @csrf
                            <select name="status_verifikasi" class="form-select mb-2" required>
                                <option value="valid" {{ $b->status_verifikasi == 'valid' ? 'selected' : '' }}>Valid</option>
                                <option value="invalid" {{ $b->status_verifikasi == 'invalid' ? 'selected' : '' }}>Invalid</option>
                            </select>
                            <input type="text" name="catatan" class="form-control mb-2" value="{{ $b->catatan }}" placeholder="Catatan (opsional)">
                            <button class="btn btn-sm btn-primary">Simpan</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
