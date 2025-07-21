@extends('layouts.master')

@section('content')

<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h4 class="mb-4">Laporan Hasil Pelatihan</h4>
    <form action="{{ route('pegawai.laporan.store', $pelatihan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Info Pelatihan --}}
        <div class="mb-3">
            <label class="form-label">Nama Pelatihan</label>
            <input type="text" class="form-control" value="{{ $pelatihan->nama }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Pelatihan</label>
            <input type="text" class="form-control"
                value="{{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($pelatihan->tanggal_selesai)->format('d-m-Y') }}"
                disabled>
        </div>

        {{-- Ringkasan Kegiatan --}}
        <div class="mb-3">
            <label for="ringkasan" class="form-label">Ringkasan Kegiatan</label>
            <textarea name="ringkasan" id="ringkasan" class="form-control" rows="5"
                >{{ old('ringkasan') }}</textarea>
        </div>

        {{-- Rencana Tindak Lanjut --}}
        <div class="mb-3">
            <label class="form-label">Rencana Tindak Lanjut (RTL)</label>
            <ul id="rtl-list">
                <li> <input type="text" name="rtl[]" class="form-control mb-2" placeholder="Tulis rencana..."> </li>
            </ul>
            <button type="button" id="tambah-rtl" class="btn btn-sm btn-outline-primary">+ Tambah Poin</button>
        </div>

        {{-- Upload Dokumen Laporan --}}
        <div class="mb-3">
            <label for="file_laporan" class="form-label">Upload Dokumen Laporan</label>
            <input type="file" name="file_laporan" class="form-control" >
            <small class="text-muted">Format: PDF, DOC, DOCX</small>
        </div>

        {{-- Upload Surat Tugas --}}
        <div class="mb-3">
            <label for="file_surat_tugas" class="form-label">Upload Surat Tugas yang Sudah Ditandatangani</label>
            <input type="file" name="file_surat_tugas" class="form-control" >
            <small class="text-muted">Format: PDF, JPG, PNG</small>
        </div>

        <div class="mt-4">
            <a href="{{ route('pegawai.dashboard') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Kirim Laporan</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const list = document.getElementById('rtl-list');
        const btnTambah = document.getElementById('tambah-rtl');

        if (btnTambah && list) {
            btnTambah.addEventListener('click', function () {
                const item = document.createElement('li');
                item.className = 'mb-2 d-flex align-items-start';

                item.innerHTML = `
                    <input type="text" name="rtl[]" class="form-control me-2" placeholder="Tulis rencana...">
                    <button type="button" class="btn btn-outline-danger btn-hapus-rtl">−</button>
                `;

                list.appendChild(item);
            });

            // Event delegation untuk tombol hapus
            list.addEventListener('click', function (e) {
                if (e.target.classList.contains('btn-hapus-rtl')) {
                    const li = e.target.closest('li');
                    if (li) li.remove();
                }
            });
        }
    });
</script>

@endsection
