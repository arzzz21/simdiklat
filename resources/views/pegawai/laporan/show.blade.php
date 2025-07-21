@extends('layouts.master')
@section('title', 'Detail Laporan Pelatihan')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Detail Laporan Pelatihan</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="20%">Nama Pelatihan</th>
                <td>{{ $laporan->pelatihan->nama }}</td>
            </tr>
            <tr>
                <th>Ringkasan Kegiatan</th>
                <td>{{ $laporan->ringkasan }}</td>
            </tr>
            <tr>
                <th>Rencana Tindak Lanjut</th>
                <td>
                    <ul>
                        @foreach ($laporan->rtl as $point)
                            <li>{{ $point }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            <tr>
                <th>Laporan File</th>
                <td>
                    <a href="{{ asset('storage/' . $laporan->file_laporan) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        Lihat Laporan
                    </a>
                </td>
            </tr>
            <tr>
                <th>Surat Tugas TTD</th>
                <td>
                    <a href="{{ asset('storage/' . $laporan->file_surat_tugas) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        Lihat Surat
                    </a>
                </td>
            </tr>
            <tr>
                <th>Status</th>
                <td><span class="badge bg-info">{{ ucfirst($laporan->status) }}</span></td>
            </tr>
        </table>

        <a href="{{ route('pegawai.dashboard') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection
