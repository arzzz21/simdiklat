@extends('layouts.master')
@section('title', 'Detail Laporan')

@section('content')
@if ($laporan->status === "revisi")
        <div class="alert alert-warning">
            <strong>⚠️ Beberapa laporan belum dilakukan perbaikan.</strong>
        </div>
    @endif
<div class="card">
    <div class="card-header">
        <h5>Detail Laporan Pelatihan</h5>
    </div>
    <div class="card-body">
        <p><strong>Pegawai:</strong> {{ $laporan->pegawai->nama }}</p>
        <p><strong>Pelatihan:</strong> {{ $laporan->pelatihan->nama }}</p>
        <p><strong>Ringkasan:</strong> {{ $laporan->ringkasan }}</p>
        <p><strong>RTL:</strong></p>
        <ul>
            @foreach ($laporan->rtl as $r)
                <li>{{ $r }}</li>
            @endforeach
        </ul>
        <p><strong>Laporan File:</strong>
            <a href="{{ asset('storage/' . $laporan->file_laporan) }}" target="_blank">Lihat</a>
        </p>
        <p><strong>Surat Tugas TTD:</strong>
            <a href="{{ asset('storage/' . $laporan->file_surat) }}" target="_blank">Lihat</a>
        </p>

        <form action="{{ route('manajer.laporan.verifikasi', $laporan->id) }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select" required>
                    <option value="disetujui" {{ $laporan->status == 'disetujui' ? 'selected' : '' }}>Setujui</option>
                    <option value="revisi" {{ $laporan->status == 'revisi' ? 'selected' : '' }}>Revisi</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control">{{ $laporan->catatan }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Simpan Verifikasi</button>
        </form>
    </div>
</div>
@endsection
