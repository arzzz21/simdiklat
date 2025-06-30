@extends('layouts.master')
@section('title', 'Edit Jenis Program')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit Jenis Program</h4>
                <form action="{{ route('jenis-program.update', $jenisProgram->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Nama Program</label>
                        <input type="text" name="nama" class="form-control" value="{{ $jenisProgram->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Metode Biaya</label>
                        <select name="metode_biaya" class="form-control">
                            <option value="per_bulan" {{ $jenisProgram->metode_biaya == 'per_bulan' ? 'selected' : '' }}>Per Bulan</option>
                            <option value="flat" {{ $jenisProgram->metode_biaya == 'flat' ? 'selected' : '' }}>Flat</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Biaya</label>
                        <input type="number" name="biaya" class="form-control" value="{{ $jenisProgram->biaya }}" required>
                    </div>
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('jenis-program.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
