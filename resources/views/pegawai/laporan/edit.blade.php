@extends('layouts.master')
@section('title', 'Edit Laporan Pelatihan')

@section('content')

<div class="card">
    <div class="card-header">
        <h5>Edit Laporan Pelatihan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('pegawai.laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <h4 class="mb-4">Laporan Hasil Pelatihan</h4>
            <div class="mb-3">
                <label class="form-label">Nama Pelatihan</label>
                <input type="text" class="form-control" value="{{ $laporan->pelatihan->nama }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Pelatihan</label>
                <input type="text" class="form-control"
                    value="{{ \Carbon\Carbon::parse($laporan->pelatihan->tanggal_mulai)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($laporan->pelatihan->tanggal_selesai)->format('d-m-Y') }}"
                    disabled>
            </div>
            {{-- Ringkasan Kegiatan --}}
            <div class="mb-3">
                <label for="ringkasan" class="form-label">Ringkasan Kegiatan</label>
                <textarea name="ringkasan" id="ringkasan" class="form-control" rows="4"
                    required>{{ old('ringkasan', $laporan->ringkasan) }}</textarea>
                @error('ringkasan') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Rencana Tindak Lanjut --}}
            <div class="mb-3">
                <label class="form-label">Rencana Tindak Lanjut (RTL)</label>
                <div id="rtl-container">
                    @foreach (old('rtl', $laporan->rtl ?? []) as $index => $item)
                    <div class="input-group mb-2">
                        <input type="text" name="rtl[]" class="form-control" value="{{ $item }}"
                            required>
                        <button type="button" class="btn btn-outline-danger btn-hapus-rtl">-</button>
                    </div>
                    @endforeach
                    @if (empty(old('rtl')) && empty($laporan->rtl))
                    <div class="input-group mb-2">
                        <input type="text" name="rtl[]" class="form-control"
                            placeholder="Contoh: Membuat modul pelatihan ulang" required>
                        <button type="button" class="btn btn-outline-danger btn-hapus-rtl">-</button>
                    </div>
                    @endif
                </div>
                <button type="button" class="btn btn-sm btn-primary" id="btn-add-rtl">Tambah Poin</button>
                @error('rtl') <small class="text-danger d-block">{{ $message }}</small> @enderror
            </div>

            {{-- File Laporan --}}
            <div class="mb-3">
                <label for="file_laporan" class="form-label">Upload Laporan (PDF)</label>
                <input type="file" class="form-control" name="file_laporan" accept="application/pdf">
                @if ($laporan->file_laporan)
                <small class="d-block">File saat ini: <a href="{{ asset('storage/'.$laporan->file_laporan) }}"
                        target="_blank">Lihat</a></small>
                @endif
                @error('file_laporan') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- File Surat Tugas --}}
            <div class="mb-3">
                <label for="file_surat_tugas" class="form-label">Upload Surat Tugas (PDF)</label>
                <input type="file" class="form-control" name="file_surat_tugas" accept="application/pdf">
                @if ($laporan->file_surat_tugas)
                <small class="d-block">File saat ini: <a href="{{ asset('storage/'.$laporan->file_surat_tugas) }}"
                        target="_blank">Lihat</a></small>
                @endif
                @error('file_surat_tugas') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('pegawai.dashboard') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById('btn-add-rtl').addEventListener('click', function () {
        const container = document.getElementById('rtl-container');
        const inputGroup = document.createElement('div');
        inputGroup.classList.add('input-group', 'mb-2');
        inputGroup.innerHTML =
            ` <input type="text" name="rtl[]" class="form-control" required> <button type="button" class="btn btn-danger btn-remove">Hapus</button> `;
        container.appendChild(inputGroup);
    });
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove')) {
            e.target.closest('.input-group').remove();
        }
    });

</script>
@endsection
