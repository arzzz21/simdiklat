@extends('layouts.master')
@section('title', 'Tambah Mahasiswa')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Tambah Mahasiswa</h4>
                <form action="{{ route('mahasiswa.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>NIM</label>
                        <input type="text" name="nim" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kampus</label>
                        <select name="kampus_id" id="kampus" class="form-control" required>
                            <option value="">-- Pilih Kampus --</option>
                            @foreach($kampus as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Program Studi</label>
                        <select name="prodi_id" id="prodi" class="form-control" required>
                            <option value="">-- Pilih Program Studi --</option>
                            @foreach($prodi as $f)
                                <option value="{{ $f->id }}">{{ $f->jenjang.'-'.$f->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control">
                    </div>
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#kampus').on('change', function () {
        var kampusID = $(this).val();
        $('#prodi').html('<option value="">Memuat...</option>');

        if(kampusID) {
            $.ajax({
                url: '/admin/get-prodi-by-kampus/' + kampusID,
                type: 'GET',
                success: function (data) {
                    $('#prodi').empty().append('<option value="">-- Pilih Fakultas --</option>');
                    $.each(data, function (key, value) {
                        $('#prodi').append('<option value="' + value.id + '">' + value.jenjang + ' - ' + value.nama + '</option>');
                    });
                }
            });
        } else {
            $('#prodi').html('<option value="">-- Pilih Program Studi --</option>');
        }
    });
</script>
@endsection
