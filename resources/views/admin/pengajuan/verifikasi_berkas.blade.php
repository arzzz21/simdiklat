@extends('layouts.master')
@section('title', 'Verifikasi Berkas Pengajuan')

@section('content')
<div class="card">
  <div class="card-header"><h5>Verifikasi Berkas Pengajuan</h5></div>
  <div class="card-body">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach($pengajuans as $p)
    <div class="border p-3 mb-4 rounded shadow-sm">
      <h6>{{ $p->user->name }} - {{ $p->jenisProgram->nama }} ({{ $p->prodi->jenjang }}-{{ $p->prodi->nama }})</h6>
      <p><strong>Periode:</strong> {{ $p->tanggal_mulai }} s/d {{ $p->tanggal_selesai }}</p>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nama Berkas</th>
            <th>File</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($p->berkas as $b)
            <tr>
              <td>{{ $b->nama_berkas }}</td>
              <td><a href="{{ asset('storage/' . $b->file) }}" target="_blank">Lihat</a></td>
              <td>
                @if($b->status_verifikasi == 'valid')
                  <span class="badge bg-success">Valid</span>
                @elseif($b->status_verifikasi == 'invalid')
                  <span class="badge bg-danger">Invalid</span>
                @else
                  <span class="badge bg-warning">Menunggu</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <form method="POST" action="{{ route('admin.pengajuan.verifikasi.berkas', $p->id) }}">
        @csrf
        <div class="row">
          <div class="col-md-6 mb-2">
            <select name="status" class="form-select" required>
              <option value="terverifikasi" {{ $p->status == 'terverifikasi' ? 'selected' : '' }}>Berkas Lengkap - Terverifikasi</option>
              <option value="berkas_tidak_sesuai" {{ $p->status == 'berkas_tidak_sesuai' ? 'selected' : '' }}>Berkas Tidak Sesuai</option>
            </select>
          </div>
          <div class="col-md-6 mb-2">
            <input type="text" name="catatan_berkas" class="form-control" placeholder="Catatan (opsional)" value="{{ $p->catatan_berkas }}">
          </div>
        </div>
        <button class="btn btn-primary btn-sm">Simpan Verifikasi</button>
      </form>
    </div>
    @endforeach

  </div>
</div>
@endsection
