@extends('layouts.master')
@section('title', 'Edit Fakultas')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit Fakultas</h4>
                <form action="{{ route('fakultas.update', $fakulta->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ $fakulta->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Kampus</label>
                        <select name="kampus_id" class="form-control" required>
                            @foreach($kampus as $k)
                                <option value="{{ $k->id }}" {{ $fakulta->kampus_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('fakultas.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
