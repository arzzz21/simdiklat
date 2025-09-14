@extends('layouts.master')
@section('title', 'Tambah Akun Dosen')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Tambah Akun Dosen</h4>
                <form action="{{ route('admin.dosen.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
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
                    <div class="mb-3">
                        <label>Fakultas</label>
                        <select name="fakultas_id" class="form-control" required>
                            <option value="">-- Pilih Fakultas --</option>
                            @foreach($fakultas as $f)
                                <option value="{{ $f->id }}">{{ $f->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="mb-3">
                        <label>Fakultas</label>
                        <input type="text" name="fakultas" class="form-control" required>
                    </div> --}}
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
