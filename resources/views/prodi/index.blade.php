@extends('layouts.master')
@section('title', 'Data Program Studi')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Program Studi</h4>
                <a href="{{ route('prodi.create') }}" class="btn btn-primary mb-3">Tambah Program Studi</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Program Studi</th>
                            <th>Fakultas</th>
                            <th>Kampus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->fakultas->nama ?? '-' }}</td>
                            <td>{{ $item->fakultas->kampus->nama ?? '-' }}</td>
                            <td>
                                <a href="{{ route('prodi.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('prodi.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
