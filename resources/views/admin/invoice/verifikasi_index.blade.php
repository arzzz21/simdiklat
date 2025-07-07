@extends('layouts.master')
@section('title', 'Verifikasi Invoice')

@section('content')
<div class="card mb-4">
  <div class="card-header"><h5>Filter Invoice</h5></div>
  <div class="card-body">
    <form method="GET" action="{{ route('admin.invoice.verifikasi.index') }}" class="row g-3">
      <div class="col-md-3">
        <label>Status Verifikasi</label>
        <select name="status" class="form-select">
          <option value="">-- Semua --</option>
          <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Diverifikasi</option>
          <option value="sudah" {{ request('status') == 'sudah' ? 'selected' : '' }}>Sudah Diverifikasi</option>
        </select>
      </div>
      <div class="col-md-3">
        <label>Tanggal Awal</label>
        <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
      </div>
      <div class="col-md-3">
        <label>Tanggal Akhir</label>
        <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
      </div>
      <div class="col-md-3 align-self-end">
        <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header"><h5>Daftar Invoice</h5></div>
  <div class="card-body">
    <table class="table table-bordered table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Program</th>
          <th>Total</th>
          <th>Status</th>
          <th>Tanggal</th>
          <th>Bukti</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($invoices as $inv)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $inv->pengajuan->jenisProgram->nama }}</td>
          <td>Rp{{ number_format($inv->total) }}</td>
          <td>
            <span class="badge bg-{{
              $inv->status == 'menunggu_verifikasi' ? 'warning' :
              ($inv->status == 'lunas' ? 'success' : 'danger') }}">
              {{ ucfirst($inv->status) }}
            </span>
          </td>
          <td>{{ $inv->created_at->format('d-m-Y H:i') }}</td>
          <td>
            @if($inv->bukti_pembayaran)
              <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalBukti{{ $inv->id }}">Lihat</button>

              <!-- Modal -->
              <div class="modal fade" id="modalBukti{{ $inv->id }}" tabindex="-1">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Bukti Pembayaran</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      @php
                        $ext = pathinfo($inv->bukti_pembayaran, PATHINFO_EXTENSION);
                      @endphp

                      @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                        <img src="{{ asset('storage/' . $inv->bukti_pembayaran) }}" class="img-fluid">
                      @elseif(strtolower($ext) === 'pdf')
                        <iframe src="{{ asset('storage/' . $inv->bukti_pembayaran) }}" width="100%" height="500px"></iframe>
                      @else
                        <p>Tidak bisa ditampilkan. <a href="{{ asset('storage/' . $inv->bukti_pembayaran) }}" target="_blank">Download</a></p>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @else
              <em>-</em>
            @endif
          </td>
          <td>
            @if ($inv->status == 'menunggu_verifikasi')
              <a href="{{ route('admin.invoice.verifikasi.show', $inv->id) }}" class="btn btn-sm btn-primary">Verifikasi</a>
            @else
              <em>-</em>
            @endif
          </td>
        </tr>
        @empty
        <tr><td colspan="6"><em>Tidak ada data</em></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
