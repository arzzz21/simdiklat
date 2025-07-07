@extends('layouts.master')
@section('title', 'Invoice Pengajuan')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5>Invoice</h5>
    {{-- <button onclick="window.print()" class="btn btn-outline-primary btn-sm d-print-none">Cetak</button> --}}
    <a href="{{ route('dosen.invoice.cetak', $pengajuan->invoice->id) }}" class="btn btn-outline-secondary" target="_blank">
        <i class="bi bi-printer"></i> Cetak PDF
    </a>
  </div>
  <div class="card-body">
    <p><strong>Nama Program:</strong> {{ $pengajuan->jenisProgram->nama }}</p>
    <p><strong>Lama:</strong> {{ $pengajuan->invoice->jumlah_bulan }} bulan</p>
    <p><strong>Biaya per Bulan:</strong> Rp{{ number_format($pengajuan->invoice->biaya_per_bulan) }}</p>
    <p><strong>Total Tagihan:</strong> Rp{{ number_format($pengajuan->invoice->total) }}</p>
    <p><strong>Status Pembayaran:</strong>
        <span class="badge bg-{{ $pengajuan->invoice->status == 'lunas' ? 'success' : ($pengajuan->invoice->status == 'menunggu_verifikasi' ? 'warning' : 'secondary') }}">
            {{ ucfirst($pengajuan->invoice->status) }}
        </span>
    </p>

    <hr>

    {{-- Upload Bukti Pembayaran --}}
    @if($pengajuan->invoice->status != 'lunas')
      <form action="{{ route('dosen.invoice.upload', $pengajuan->id) }}" method="POST" enctype="multipart/form-data" class="d-print-none">
        @csrf
        <div class="mb-3">
          <label for="bukti">Upload Bukti Pembayaran (JPG/PNG/PDF)</label>
          <input type="file" name="bukti" class="form-control" required>
        </div>
        @if ($pengajuan->invoice->bukti_pembayaran)
          <p>📄 Bukti saat ini:
            <a href="{{ asset('storage/'.$pengajuan->invoice->bukti_pembayaran) }}" target="_blank">Lihat Bukti</a>
          </p>
        @endif
        <button type="submit" class="btn btn-success">Kirim Bukti</button>
      </form>
    @endif

  </div>
</div>
@endsection
