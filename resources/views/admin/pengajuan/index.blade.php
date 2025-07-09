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
          <th>#</th>
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
          <td>{{ $loop->iteration }}</td>
          <td>{{ $p->user->name }}</td>
          <td>{{ $p->jenisProgram->nama }}</td>
          <td>{{ $p->program_studi }}</td>
          <td>{{ $p->tanggal_mulai }} s/d {{ $p->tanggal_selesai }}</td>
          <td>
            @if($p->status == 'diajukan')
              <span class="badge bg-warning">Diajukan</span>
            @elseif($p->status == 'diterima')
              <span class="badge bg-success">Diterima</span>
            @elseif($p->status == 'ditolak')
              <span class="badge bg-danger">Ditolak</span>
            @else
              <span class="badge bg-primary">{{ $p->status }}</span>
            @endif
          </td>
          <td>
            <!-- Tombol -->
            @if ($p->status === 'diajukan')
                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalVerif{{ $p->id }}">Verifikasi</button>
            @else
                <button class="btn btn-sm btn-secondary" disabled>Sudah Diverifikasi</button>
            @endif

            <!-- Modal -->
            <div class="modal fade" id="modalVerif{{ $p->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form id="form-verifikasi-{{ $p->id }}" action="{{ route('admin.pengajuan.verifikasi', $p->id) }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda ingin menerima atau menolak pengajuan ini?</p>
                    <div class="mb-2">
                    <select name="status" class="form-select status-select" data-id="{{ $p->id }}" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                    </div>
                    <div class="mb-2 form-ditolak form-ditolak-{{ $p->id }}" style="display: none;">
                        <label>Alasan Penolakan (jika ditolak)</label>
                        <textarea name="alasan" class="form-control" rows="3"></textarea>
                    </div>
                    {{-- Diterima --}}
                    <div class="form-diterima form-diterima-{{ $p->id }}" style="display: none;">
                        <div class="mb-2">
                            <label>Unit Magang</label>
                            <input type="text" name="unit_magang" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Nama Pembimbing RS</label>
                            <input type="text" name="pembimbing_rumah_sakit" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>NIP Pembimbing</label>
                            <input type="text" name="nip_pembimbing" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Jabatan Pembimbing</label>
                            <input type="text" name="jabatan_pembimbing" class="form-control">
                        </div>
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

            @elseif($p->status == 'berkas_tidak_sesuai')
                <span class="badge bg-danger">Berkas Tidak Sesuai</span><br>
                <small>Oleh: {{ $p->verifikator->name ?? '-' }}</small><br>
                <small>{{ $p->tanggal_verifikasi ? \Carbon\Carbon::parse($p->tanggal_verifikasi)->format('d-m-Y H:i') : '-' }}</small><br>
                <small><strong>Alasan:</strong> {{ $p->alasan_ditolak }}</small>

            @elseif($p->status == 'terverifikasi')
                <span class="badge bg-info">Terverifikasi</span><br>
                <small>Oleh: {{ $p->verifikator->name ?? '-' }}</small><br>
                <small>{{ $p->tanggal_verifikasi ? \Carbon\Carbon::parse($p->tanggal_verifikasi)->format('d-m-Y H:i') : '-' }}</small>

            @elseif($p->status == 'invoice_diterbitkan')
                <span class="badge bg-primary">Invoice Diterbitkan</span><br>
                <small>Oleh: {{ $p->verifikator->name ?? '-' }}</small><br>
                <small>{{ $p->tanggal_verifikasi ? \Carbon\Carbon::parse($p->tanggal_verifikasi)->format('d-m-Y H:i') : '-' }}</small>

            @elseif($p->status == 'menunggu_verifikasi_pembayaran')
                <span class="badge bg-secondary">Menunggu Verifikasi Pembayaran</span><br>
                <small>Oleh: {{ $p->verifikator->name ?? '-' }}</small><br>
                <small>{{ $p->tanggal_verifikasi ? \Carbon\Carbon::parse($p->tanggal_verifikasi)->format('d-m-Y H:i') : '-' }}</small>

            @elseif($p->status == 'selesai')
                <span class="badge bg-success">Selesai</span><br>
                <small>Oleh: {{ $p->verifikator->name ?? '-' }}</small><br>
                <small>{{ $p->tanggal_verifikasi ? \Carbon\Carbon::parse($p->tanggal_verifikasi)->format('d-m-Y H:i') : '-' }}</small>

            @elseif($p->status == 'ditolak')
                <span class="badge bg-danger">Ditolak</span><br>
                <small>Oleh: {{ $p->verifikator->name ?? '-' }}</small><br>
                <small>{{ $p->tanggal_verifikasi ? \Carbon\Carbon::parse($p->tanggal_verifikasi)->format('d-m-Y H:i') : '-' }}</small><br>
                <small><strong>Alasan:</strong> {{ $p->alasan_ditolak }}</small>

            @else
                <span class="badge bg-dark">{{ $p->status }}</span>
            @endif

            @if ($p->status === 'terverifikasi' && !$p->invoice)
                <br><a href="{{ route('admin.invoice.create', $p->id) }}" class="btn btn-sm btn-warning">Terbitkan Invoice</a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const selects = document.querySelectorAll(".status-select");

    selects.forEach(select => {
        const id = select.dataset.id;
        const formDiterima = document.querySelector(".form-diterima-" + id);
        const formDitolak = document.querySelector(".form-ditolak-" + id);

        // Pastikan saat pertama dibuka sesuai value saat ini
        toggleForm(select.value, formDiterima, formDitolak);

        select.addEventListener("change", function () {
            toggleForm(this.value, formDiterima, formDitolak);
        });
    });

    function toggleForm(value, formDiterima, formDitolak) {
        if (value === "diterima") {
            formDiterima.style.display = "block";
            formDitolak.style.display = "none";
        } else if (value === "ditolak") {
            formDiterima.style.display = "none";
            formDitolak.style.display = "block";
        } else {
            formDiterima.style.display = "none";
            formDitolak.style.display = "none";
        }
    }
});
</script>



@endsection
