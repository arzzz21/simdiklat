@extends('layouts.master')
@section('title', 'Terbitkan Invoice')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Invoice Pengajuan</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Nama Program</th>
                <td>{{ $jenis->nama }}</td>
            </tr>
            <tr>
                <th>Rentang Waktu</th>
                <td>{{ $Mulai }} s/d {{ $Selesai }}</td>
            </tr>
            <tr>
                <th>Lama Magang</th>
                <td>
                    @if($jenis->metode_biaya == 'per_bulan')
                    {{ $lamaMagang }}
                    @elseif($jenis->metode_biaya == 'per_minggu')
                    {{ $jumlahMinggu }} minggu
                    @else
                    {{ $lamaMagang }} ({{ $jumlahHari }} hari)
                    @endif
                </td>
            </tr>
            <tr>
                <th>Jumlah Mahasiswa</th>
                <td>{{ $pengajuan->mahasiswas->count() }} orang</td>
            </tr>
            <tr>
                <th>Metode Biaya</th>
                <td>{{ ucfirst(str_replace('_', ' ', $jenis->metode_biaya)) }}</td>
            </tr>
            <tr>
                <th>Biaya per
                    @if($jenis->metode_biaya == 'per_bulan')
                    Bulan
                    @elseif($jenis->metode_biaya == 'per_minggu')
                    Minggu
                    @else
                    Program
                    @endif
                </th>
                <td>Rp{{ number_format($jenis->biaya, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Biaya</th>
                <td><strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
        </table>

        <form action="{{ route('admin.invoice.store', $pengajuan->id) }}" method="POST">
            @csrf
            <input type="hidden" name="total" value="{{ $total }}">
            <button type="submit" class="btn btn-primary">Terbitkan Invoice</button>
            <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
