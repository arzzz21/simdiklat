@extends('layouts.master')
@section('title', 'Upload Berkas Pengajuan')

@section('content')
<a href="{{ route('dosen.pengajuan.index') }}" class="btn btn-secondary mb-3">
  ← Kembali ke Daftar Pengajuan
</a>
@if ($pengajuan->status == 'berkas_tidak_sesuai')
    <div class="alert alert-danger">
        <strong>Catatan dari Admin:</strong><br>
        {{ $pengajuan->catatan_berkas ?? 'Berkas Anda perlu diperbaiki. Silakan upload ulang sesuai petunjuk.' }}
    </div>
@endif
<div class="alert alert-danger">
    <strong>Berkas 1 mahasiswa terdiri dari :</strong><br>
    <ul>
        <li>Surat Permohonan Magang</li>
        <li>Kartu Identitas</li>
        <li>Surat Keterangan Sehat</li>
        <li>Surat Ijin Orang Tua</li>
    </ul>
</div>
<div class="card">
  <div class="card-header">
    <h5>Upload Berkas Pengajuan</h5>
  </div>
  <div class="card-body">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('dosen.pengajuan.berkas.store', $pengajuan->id) }}" enctype="multipart/form-data" class="mb-4">
      @csrf
      <div class="mb-3">
        <label>Nama Berkas</label>
        <input type="text" name="nama_berkas" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Pilih File</label>
        <input type="file" name="file" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <h5>Daftar Berkas</h5>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Nama Berkas</th>
          <th>File</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($pengajuan->berkas as $b)
          <tr>
            <td>{{ $b->nama_berkas }}</td>
            <td><a href="{{ asset('storage/' . $b->file) }}" target="_blank">Lihat</a></td>
            <td>
              <form action="{{ route('dosen.pengajuan.berkas.destroy', $b->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus berkas ini?')">Hapus</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </div>
</div>
@endsection
