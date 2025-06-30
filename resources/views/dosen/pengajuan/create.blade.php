@extends('layouts.master')
@section('title', 'Form Pengajuan')

@section('content')

<h4 class="mb-4">Form Pengajuan PKL / Magang</h4>
<form action="{{ route('dosen.pengajuan.store') }}" method="POST">
    @csrf
    {{-- Jenis Program --}}
    <div class="mb-3">
        <label for="jenis_program_id">Jenis Program</label>
        <select name="jenis_program_id" class="form-control" required>
            <option value="">-- Pilih Jenis Program --</option>
            @foreach ($jenis_programs as $item)
            <option value="{{ $item->id }}">{{ $item->nama }}</option>
            @endforeach
        </select>
    </div>

    {{-- Program Studi --}}
    <div class="mb-3">
        <label for="program_studi">Program Studi</label>
        <input type="text" name="program_studi" class="form-control" required>
    </div>

    {{-- Tanggal --}}
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" required>
        </div>
    </div>

    {{-- Pilih Mahasiswa --}}
    <div class="mb-3">
        <label for="input-mahasiswa">Cari Mahasiswa</label>
        <div class="input-group">
            <select id="input-mahasiswa" class="form-select">
                <option value="">-- Pilih Mahasiswa --</option>
                @foreach ($mahasiswas as $m)
                <option value="{{ $m->id }}">{{ $m->nama }} - {{ $m->nim }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-success" onclick="tambahMahasiswa()">+ Tambah</button>
        </div>
    </div>

    {{-- Mahasiswa Terpilih --}}
    <div class="mb-3">
        <label>Mahasiswa yang Dipilih</label>
        <ul id="daftar-mahasiswa" class="list-group mt-2"></ul>
        <div id="input-terpilih"></div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Pengajuan</button>
</form>
{{-- SCRIPT --}}

<script>
    let selectedMahasiswa = [];

    function tambahMahasiswa() {
        const select = document.getElementById('input-mahasiswa');
        const id = select.value;
        const text = select.options[select.selectedIndex]?.text;
        if (!id || selectedMahasiswa.includes(id)) return;
        selectedMahasiswa.push(
        id);
        // Tampilkan di daftar
        const ul = document.getElementById('daftar-mahasiswa');
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.setAttribute('data-id', id);
        li.innerHTML = ` ${text} <button type="button" class="btn btn-sm btn-danger" onclick="hapusMahasiswa(${id})">Hapus</button> `;
        ul.appendChild(li);
        // Tambahkan input hidden agar dikirim saat submit
        const inputHidden = document.createElement('input');
        inputHidden.type = 'hidden';
        inputHidden.name = 'mahasiswa_ids[]';
        inputHidden.value = id;
        inputHidden.id = 'input-' + id;
        document.getElementById('input-terpilih').appendChild(inputHidden);
    }
    function hapusMahasiswa(id) {
        selectedMahasiswa = selectedMahasiswa.filter(val => val !== id.toString());
        const li = document.querySelector('li[data-id="' + id + '"]');
        if (li) li.remove();
        const input = document.getElementById('input-' + id);
        if (input) input.remove();
    }

</script>
@endsection
