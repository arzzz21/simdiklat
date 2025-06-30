@extends('layouts.master')

@section('title', 'Edit Kampus')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit Kampus</h4>

                <form action="{{ route('kampus.update', $kampus->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kampus</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $kampus->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control">{{ old('alamat', $kampus->alamat) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('kampus.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
