@extends('layouts.master')
@section('title', 'Edit Akun Dosen')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit Akun Dosen</h4>
                <form action="{{ route('admin.dosen.update', $dosen->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" value="{{ $dosen->name }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $dosen->email }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Kampus</label>
                        <select name="kampus_id" id="kampus" class="form-control" required>
                            @foreach($kampus as $k)
                                <option value="{{ $k->id }}" {{ $dosen->kampus_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Fakultas</label>
                        <select name="fakultas_id" id="fakultas" class="form-control" required>
                            @foreach($fakultas as $f)
                                <option value="{{ $f->id }}" {{ $dosen->fakultas_id == $f->id ? 'selected' : '' }}>{{ $f->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="mb-3">
                        <label>Fakultas</label>
                        <input type="text" name="fakultas" value="{{ $dosen->fakultas }}" class="form-control" required>
                    </div> --}}
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#kampus').on('change', function () {
        var kampusID = $(this).val();
        $('#fakultas').html('<option value="">Memuat...</option>');

        if(kampusID) {
            $.ajax({
                url: '/admin/get-fakultas-by-kampus/' + kampusID,
                type: 'GET',
                success: function (data) {
                    $('#fakultas').empty().append('<option value="">-- Pilih Fakultas --</option>');
                    $.each(data, function (key, value) {
                        $('#fakultas').append('<option value="' + value.id + '">' + value.nama + '</option>');
                    });
                }
            });
        } else {
            $('#fakultas').html('<option value="">-- Pilih Fakultas --</option>');
        }
    });
</script>
@endsection
