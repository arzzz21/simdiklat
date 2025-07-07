@extends('layouts.master')
@section('title', 'Terbitkan Invoice')

@section('content')
<div class="card">
  <div class="card-header"><h5>Terbitkan Invoice</h5></div>
  <div class="card-body">
    <p><strong>Nama Program :</strong> {{ $jenis->nama }}</p>
    <p><strong>Rentang Waktu Magang :</strong> {{ $Mulai }} s/d {{ $Selesai }}</p>
    <p><strong>Lama Magang :</strong> {{ $lamaMagang  }} </p>
    <p><strong>Biaya per Bulan :</strong> Rp{{ number_format($jenis->biaya, 0, ',', '.') }}</p>
    <p><strong>Total :</strong> Rp{{ number_format($total, 0, ',', '.') }}</p>

    <form action="{{ route('admin.invoice.store', $pengajuan->id) }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-primary">Konfirmasi & Simpan Invoice</button>
      <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection
