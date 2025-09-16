@extends('layouts.master')
@section('title', 'Tambah Program Studi')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Tambah Program Studi</h4>
                <form action="{{ route('prodi.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Jenjang</label>
                        <select name="jenjang" class="form-control" required>
                            <option value="">-- Pilih Jenjang --</option>
                                <option value="D3">D3</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Fakultas</label>
                        <select name="fakultas_id" class="form-control" required>
                            <option value="">-- Pilih Fakultas --</option>
                            @foreach($fakultas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}-{{ $k->kampus->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('prodi.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
