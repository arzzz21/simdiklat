@extends('layouts.master')
@section('title', 'Daftar In House Training')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Daftar IHT</h5> <a href="{{ route('admin.iht.create') }}" class="btn btn-primary">+
            Tambah IHT</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Waktu</th>
                    <th>Tempat</th>
                    <th>Peserta</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ihts as $iht)
                <tr>
                    <td>{{ $iht->judul }}</td>
                    <td>{{ $iht->tanggal_mulai }} - {{ $iht->tanggal_selesai }}</td>
                    <td>{{ $iht->tempat }}</td>
                    <td>{{ $iht->participants_count }} orang</td>
                    <td>
                        <a href="{{ route('admin.iht.edit', $iht->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('admin.iht.peserta', $iht->id) }}" class="btn btn-sm btn-info">Peserta</a>
                        <a href="{{ route('admin.iht.presensi', $iht->id) }}" class="btn btn-warning btn-sm">Presensi</a>
                        @php
                            $pelatihanSelesai = now()->gt($iht->tanggal_selesai);
                            $pesertas = $iht->pesertas ?? collect();
                            $adaYangBelum = $pesertas->contains(function($peserta) {
                                return empty($peserta->sertifikat_path);
                            });
                            $semuaKosong = $pesertas->every(function($peserta) {
                                return empty($peserta->sertifikat_path);
                            });
                        @endphp
                        @if ($pelatihanSelesai)
                            @if ($semuaKosong)
                                <a href="{{ route('admin.iht.generate-sertifikat', $iht->id) }}" class="btn btn-success btn-sm">
                                    Generate Sertifikat
                                </a>
                            @elseif ($adaYangBelum)
                                <a href="{{ route('admin.iht.generate-sertifikat', $iht->id) }}" class="btn btn-warning btn-sm">
                                    Perbarui Sertifikat
                                </a>
                            @endif
                        @endif
                        <form action="{{ route('admin.iht.destroy', $iht->id) }}" method="POST" style="display:inline;"
                            onsubmit="return confirm('Hapus IHT ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
