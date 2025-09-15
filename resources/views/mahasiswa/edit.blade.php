@extends('layouts.master')
@section('title', 'Edit Mahasiswa')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit Mahasiswa</h4>
                <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ $mahasiswa->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label>NIM</label>
                        <input type="text" name="nim" class="form-control" value="{{ $mahasiswa->nim }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Kampus</label>
                        <select name="kampus_id" class="form-control" required>
                            @foreach($kampus as $k)
                            <option value="{{ $k->id }}" {{ $mahasiswa->kampus_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Program Studi</label>
                        <select name="prodi_id" id="prodi" class="form-control" required>
                            <option value="">-- Pilih Program Studi --</option>
                            @foreach($prodi as $f)
                            <option value="{{ $f->id }}" {{ $mahasiswa->prodi_id == $f->id ? 'selected' : '' }}>{{ $f->jenjang.'-'.$f->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ $mahasiswa->no_hp }}">
                    </div>
                    <button class="btn btn-primary">Update</button>
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
