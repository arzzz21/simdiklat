@extends('layouts.master')
@section('title', 'Verifikasi Pengajuan')

@section('content')
<div class="card">
  <div class="card-header">
    <h5>Daftar Pengajuan Masuk</h5>
  </div>
  <div class="card-body">
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Nama Dosen</th>
          <th>Jenis Program</th>
          <th>Program Studi</th>
          <th>Tanggal</th>
          <th>Status</th>
          <th>Aksi</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        @foreach($pengajuans as $p)
        <tr>
          <td>{{ $p->user->name }}</td>
          <td>{{ $p->jenisProgram->nama }}</td>
          <td>{{ $p->program_studi }}</td>
          <td>{{ $p->tanggal_mulai }} s/d {{ $p->tanggal_selesai }}</td>
          <td>
            @if($p->status == 'diajukan')
              <span class="badge bg-warning">Diajukan</span>
            @elseif($p->status == 'diterima')
              <span class="badge bg-success">Diterima</span>
            @else
              <span class="badge bg-danger">Ditolak</span>
            @endif
          </td>
          <td>
            {{-- @if($p->status == 'diajukan')
              <form action="{{ route('admin.pengajuan.verifikasi', $p->id) }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="diterima">
                <button type="submit" class="btn btn-success btn-sm">Terima</button>
              </form>
              <form action="{{ route('admin.pengajuan.verifikasi', $p->id) }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="ditolak">
                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
              </form>
            @else
              <em>Terverifikasi</em>
            @endif --}}
            <!-- Tombol -->
            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalVerif{{ $p->id }}">Verifikasi</button>

            <!-- Modal -->
            <div class="modal fade" id="modalVerif{{ $p->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('admin.pengajuan.verifikasi', $p->id) }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda ingin menerima atau menolak pengajuan ini?</p>
                    <div class="mb-2">
                    <select name="status" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                    </div>
                    <div class="mb-2">
                    <label>Alasan Penolakan (jika ditolak)</label>
                    <textarea name="alasan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
            </div>
          </td>
          <td>
            @if($p->status == 'diajukan')
                <span class="badge bg-warning">Diajukan</span>
            @elseif($p->status == 'diterima')
                <span class="badge bg-success">Diterima</span><br>
                <small>Oleh: {{ $p->verifikator->name ?? '-' }}</small><br>
                <small>{{ $p->tanggal_verifikasi ? \Carbon\Carbon::parse($p->tanggal_verifikasi)->format('d-m-Y H:i') : '-' }}</small>
            @else
                <span class="badge bg-danger">Ditolak</span><br>
                <small>Oleh: {{ $p->verifikator->name ?? '-' }}</small><br>
                <small>{{ $p->tanggal_verifikasi ? \Carbon\Carbon::parse($p->tanggal_verifikasi)->format('d-m-Y H:i') : '-' }}</small><br>
                <small><strong>Alasan:</strong> {{ $p->alasan_ditolak }}</small>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
