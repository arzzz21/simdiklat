@extends('layouts.master')
@section('title', 'Verifikasi Berkas Pengajuan')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Verifikasi Berkas - {{ $pengajuan->user->name }}</h5>
    </div>
    <div class="card-body">

        {{-- Info Pengajuan --}}
        <div class="mb-4">
            <p><strong>Program:</strong> {{ $pengajuan->jenisProgram->nama }}</p>
            <p><strong>Program Studi:</strong> {{ $pengajuan->program_studi }}</p>
            <p><strong>Periode:</strong> {{ $pengajuan->tanggal_mulai }} s/d {{ $pengajuan->tanggal_selesai }}</p>
            <p><strong>Status Saat Ini:</strong>
                @if($pengajuan->status == 'diterima')
                    <span class="badge bg-info">Diterima</span>
                @elseif($pengajuan->status == 'terverifikasi')
                    <span class="badge bg-success">Terverifikasi</span>
                @elseif($pengajuan->status == 'berkas_tidak_sesuai')
                    <span class="badge bg-danger">Berkas Tidak Sesuai</span>
                @endif
            </p>
        </div>

        {{-- Daftar Berkas --}}
        <h6>Daftar Berkas Pengajuan</h6>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Berkas</th>
                    <th>File</th>
                    <th>Status Berkas (Opsional)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengajuan->berkas as $b)
                <tr>
                    <td>{{ $b->nama_berkas }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $b->file) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                    </td>
                    <td>
                        @if ($b->status_verifikasi == 'valid')
                            <span class="badge bg-success">Valid</span>
                        @elseif ($b->status_verifikasi == 'invalid')
                            <span class="badge bg-danger">Invalid</span>
                        @else
                            <span class="badge bg-warning">Menunggu</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">Belum ada berkas diupload.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Form Verifikasi --}}
        <form action="{{ route('admin.pengajuan.verifikasi.submit', $pengajuan->id) }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="status" class="form-label">Status Verifikasi Pengajuan</label>
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="terverifikasi">✔️ Berkas Lengkap & Sesuai - Terverifikasi</option>
                        <option value="berkas_tidak_sesuai">❌ Berkas Tidak Lengkap / Tidak Sesuai</option>
                    </select>
            </div>

            <div class="mb-3">
                <label for="catatan_berkas" class="form-label">Catatan (opsional)</label>
                <textarea name="catatan_berkas" id="catatan_berkas" class="form-control" rows="3">{{ old('catatan_berkas', $pengajuan->catatan_berkas) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Verifikasi</button>
            <a href="{{ route('admin.pengajuan.verifikasi.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
