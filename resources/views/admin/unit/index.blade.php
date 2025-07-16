@extends('layouts.master')
@section('title', 'Unit')

@section('content')

<div class="card">
    <div class="card-header">
        <h5>Daftar Unit</h5>
    </div>
    <div class="card-body"> @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('admin.unit.store') }}" method="POST" class="row g-3 mb-3">
            @csrf
            <div class="col-md-8">
                <input type="text" name="nama" class="form-control" placeholder="Nama Unit" required>
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary">+ Tambah</button>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Unit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($units as $unit)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $unit->nama }}</td>
                    <td>
                        <form action="{{ route('admin.unit.destroy', $unit->id) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div> @endsection
