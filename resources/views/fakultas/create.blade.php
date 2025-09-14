@extends('layouts.master')
@section('title', 'Tambah Fakultas')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Tambah Fakultas</h4>
                <form action="{{ route('fakultas.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kampus</label>
                        <select name="kampus_id" class="form-control" required>
                            <option value="">-- Pilih Kampus --</option>
                            @foreach($kampus as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('fakultas.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
