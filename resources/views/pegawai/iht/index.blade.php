@extends('layouts.master')
@section('title', 'Daftar In House Training')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Daftar IHT</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody> @foreach ($ihts as $peserta) <tr>
                    <td>{{ $peserta->iht->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($peserta->iht->tanggal_mulai)->format('d-m-Y') }} s/d
                        {{ \Carbon\Carbon::parse($peserta->iht->tanggal_selesai)->format('d-m-Y') }}</td>
                    <td>
                        @php
                            $today = \Carbon\Carbon::today(); $start = \Carbon\Carbon::parse($peserta->iht->tanggal_mulai);
                            $end =\Carbon\Carbon::parse($peserta->iht->tanggal_selesai);
                        @endphp
                        @if($today->between($start, $end))
                            Sedang Berlangsung
                        @elseif($today->gt($end))
                            Selesai
                        @else
                            Belum Dimulai
                        @endif
                    </td>
                    <td>
                        @if($today->between($start, $end))
                            <a href="{{ route('pegawai.iht.evaluasi', $peserta->id) }}" class="btn btn-primary btn-sm">Isi Evaluasi</a>
                        @endif
                        @if ($peserta->sertifikat_path)
                            <a href="{{ asset('storage/' . $peserta->sertifikat_path) }}" target="_blank">Lihat Sertifikat</a>
                        @else
                            Sertifikat Belum tersedia
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
