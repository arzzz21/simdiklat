@extends('layouts.master')
@section('title', 'Tambah Jenis Program')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Tambah Jenis Program</h4>
                <form action="{{ route('jenis-program.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama Program</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Metode Biaya</label>
                        <select name="metode_biaya" class="form-control">
                            <option value="per_bulan">Per Bulan</option>
                            <option value="per_minggu">Per Minggu</option>
                            <option value="flat">Flat</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Biaya</label>
                        <input type="number" name="biaya" class="form-control" required>
                    </div>
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('jenis-program.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
