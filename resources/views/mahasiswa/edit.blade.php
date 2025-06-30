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
                        <label>Program Studi</label>
                        <input type="text" name="prodi" class="form-control" value="{{ $mahasiswa->prodi }}">
                    </div>
                    <div class="mb-3">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ $mahasiswa->no_hp }}">
                    </div>
                    <div class="mb-3">
                        <label>Kampus</label>
                        <select name="kampus_id" class="form-control" required>
                            @foreach($kampus as $k)
                                <option value="{{ $k->id }}" {{ $mahasiswa->kampus_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
