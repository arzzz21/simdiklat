@extends('layouts.master')
@section('title', 'Tambah Pelatihan')

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.pelatihan.store') }}" method="POST" enctype="multipart/form-data"> @csrf <div class="mb-3"> <label>Nama
                    Pelatihan</label> <input type="text" name="nama" class="form-control" required> </div>
            <div class="mb-3"> <label>Tempat / Alamat</label> <textarea name="tempat" class="form-control" rows="2" required></textarea> </div>
            <div class="row">
                <div class="col-md-6 mb-3"> <label>Tanggal Mulai</label> <input type="date" name="tanggal_mulai"
                        class="form-control" required> </div>
                <div class="col-md-6 mb-3"> <label>Tanggal Selesai</label> <input type="date" name="tanggal_selesai"
                        class="form-control" required> </div>
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
            <div id="peserta-inputs"></div>
            <div class="mb-3"> <label>Keterangan</label> <textarea name="keterangan" class="form-control"></textarea></div>
            <div class="mb-3">
                <label>Berkas Informasi / Undangan (PDF / JPG)</label>
                <input type="file" name="file_info" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.pelatihan.index') }}" class="btn btn-secondary ms-2">Batal</a>
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
        tambahBtn.addEventListener('click',
        function ()
        {
            const selectedOption = selectPegawai.options[selectPegawai.selectedIndex];
            const pegawaiId = selectedOption.value;
            const pegawaiNama = selectedOption.dataset.nama;
            if (!pegawaiId || document.getElementById('peserta-item-' + pegawaiId))
            {
                return;
            }
            // tampilkan di daftar
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.id = 'peserta-item-' + pegawaiId;
            li.innerHTML = ` ${pegawaiNama} <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="${pegawaiId}">Hapus</button> `;
            daftar.appendChild(li);
            // hidden input
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'peserta[]';
            input.value = pegawaiId;
            input.id = 'input-peserta-' + pegawaiId;
            inputContainer.appendChild(input);
        });
        // hapus peserta
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
