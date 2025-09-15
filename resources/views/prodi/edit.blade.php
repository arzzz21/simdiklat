@extends('layouts.master')
@section('title', 'Edit Program Studi')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit Program Studi</h4>
                <form action="{{ route('prodi.update', $prodi->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Jenjang</label>
                        <select name="jenjang" class="form-control" required>
                            <option value="">-- Pilih Jenjang --</option>
                                <option value="D3" {{ $prodi->jenjang == "D3" ? 'selected' : '' }}>D3</option>
                                <option value="S1" {{ $prodi->jenjang == "S1" ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ $prodi->jenjang == "S2" ? 'selected' : '' }}>S2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ $prodi->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Fakultas</label>
                        <select name="fakultas_id" class="form-control" required>
                            @foreach($fakultas as $k)
                                <option value="{{ $k->id }}" {{ $prodi->fakultas_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('prodi.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
