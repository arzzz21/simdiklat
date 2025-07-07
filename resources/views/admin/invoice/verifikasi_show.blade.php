@extends('layouts.master')
@section('title', 'Verifikasi Pembayaran')

@section('content')
<div class="card">
  <div class="card-header"><h5>Verifikasi Pembayaran</h5></div>
  <div class="card-body">
    <p><strong>Nama Program:</strong> {{ $invoice->pengajuan->jenisProgram->nama }}</p>
    <p><strong>Total:</strong> Rp{{ number_format($invoice->total) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>

    <p><strong>Bukti Pembayaran:</strong></p>
    @if ($invoice->bukti_pembayaran)
        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalBukti{{ $invoice->id }}">
            Lihat Bukti
        </button>
    @else
      <p><em>Belum diunggah</em></p>
    @endif

    <form action="{{ route('admin.invoice.verifikasi.store', $invoice->id) }}" method="POST" class="mt-3">
      @csrf
      <div class="mb-3">
        <label>Verifikasi:</label><br>
        <button name="status" value="lunas" class="btn btn-success">Tandai Lunas</button>
        <button name="status" value="ditolak" class="btn btn-danger">Tolak Bukti</button>
      </div>
    </form>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalBukti{{ $invoice->id }}" tabindex="-1" aria-labelledby="modalBuktiLabel{{ $invoice->id }}" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalBuktiLabel{{ $invoice->id }}">Bukti Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" style="min-height: 600px">
        @php
          $ext = pathinfo($invoice->bukti_pembayaran, PATHINFO_EXTENSION);
        @endphp

        @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
          <img src="{{ asset('storage/' . $invoice->bukti_pembayaran) }}" class="img-fluid" alt="Bukti Pembayaran">
        @elseif(strtolower($ext) === 'pdf')
          <iframe src="{{ asset('storage/' . $invoice->bukti_pembayaran) }}" width="100%" height="500px"></iframe>
        @else
          <p class="text-danger">File tidak dapat ditampilkan. Unduh manual:
            <a href="{{ asset('storage/' . $invoice->bukti_pembayaran) }}" target="_blank">Download</a>
          </p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
