@extends('layouts.master')
@section('title', 'Edit Pelatihan')

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.pelatihan.update', $pelatihan->id) }}" method="POST" enctype="multipart/form-data"> @csrf @method('PUT')
            <div class="mb-3">
                <label>Nama Pelatihan</label>
                <input type="text" name="nama" class="form-control" value="{{ $pelatihan->nama }}" required>
            </div>
            <div class="mb-3">
                <label>Tempat / Alamat</label>
                <textarea name="tempat" class="form-control" rows="2" required>{{ old('tempat', $pelatihan->tempat ?? '') }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ $pelatihan->tanggal_mulai }}"
                        required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control"
                        value="{{ $pelatihan->tanggal_selesai }}" required>
                </div>
            </div>
            <div class="mb-3"> <label>Pilih Peserta</label>
                <div class="d-flex gap-2"> <select id="pegawai-select" class="form-select" style="width: 100%;">
                        <option value="">-- Cari Pegawai --</option> @foreach($pegawais as $p) <option
                            value="{{ $p->id }}" data-nama="{{ $p->nama }}">{{ $p->nama }} - {{ $p->unit->nama }}
                        </option> @endforeach
                    </select> <button type="button" class="btn btn-primary" id="tambah-peserta">Tambah</button> </div>
            </div>
            <div class="mb-3"> <label>Daftar Peserta:</label>
                <ul id="daftar-peserta" class="list-group"> {{-- peserta akan muncul di sini --}} </ul>
            </div>
                <ul id="daftar-peserta" class="list-group">
                    @foreach ($pelatihan->peserta as $p)
                    <li class="list-group-item d-flex justify-content-between align-items-center" id="peserta-item-{{ $p->id }}">
                        {{ $p->nama }}
                        <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="{{ $p->id }}">Hapus</button>
                    </li>
                    @endforeach
                </ul>
                <div id="peserta-inputs">
                    @foreach ($pelatihan->peserta as $p)
                    <input type="hidden" name="peserta[]" value="{{ $p->id }}" id="input-peserta-{{ $p->id }}">
                    @endforeach
                </div>
            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control">{{ $pelatihan->keterangan }}</textarea>
            </div>
            <div class="mb-3">
                <label>Ganti Berkas Informasi / Undangan (PDF / JPG)</label>
                <input type="file" name="file_info" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <div class="mb-3">
                @if (isset($pelatihan) && $pelatihan->file_info)
                    <p class="mt-2">
                        <a href="{{ asset('storage/' . $pelatihan->file_info) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                            Lihat Berkas Lama
                        </a>
                    </p>
                @endif
            </div>
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded",
    function ()
    {
        const daftar = document.getElementById('daftar-peserta');
        const inputContainer = document.getElementById('peserta-inputs');
        const tambahBtn = document.getElementById('tambah-peserta');
        const selectPegawai = document.getElementById('pegawai-select');
        tambahBtn.addEventListener('click', function ()
        {
            const selectedOption = selectPegawai.options[selectPegawai.selectedIndex];
            const pegawaiId = selectedOption.value;
            const pegawaiNama = selectedOption.dataset.nama;
            if (!pegawaiId || document.getElementById('peserta-item-' + pegawaiId))
            {
                return;
            }
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.id = 'peserta-item-' + pegawaiId; li.innerHTML = ` ${pegawaiNama} <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="${pegawaiId}">Hapus</button> `;
            daftar.appendChild(li);
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'peserta[]';
            input.value = pegawaiId;
            input.id = 'input-peserta-' + pegawaiId;
            inputContainer.appendChild(input);
        });
        daftar.addEventListener('click', function (e)
        {
            if (e.target.classList.contains('btn-hapus'))
            {
                const id = e.target.dataset.id;
                document.getElementById('peserta-item-' + id).remove();
                document.getElementById('input-peserta-' + id).remove();
            }
        });
    });
</script>

@endsection
