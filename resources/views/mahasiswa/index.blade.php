@extends('layouts.master')
@section('title', 'Data Mahasiswa')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Mahasiswa</h4>
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary mb-3">Tambah Mahasiswa</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Prodi</th>
                            <th>No HP</th>
                            <th>Kampus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->nim }}</td>
                            <td>{{ $item->prodi }}</td>
                            <td>{{ $item->no_hp }}</td>
                            <td>{{ $item->kampus->nama ?? '-' }}</td>
                            <td>
                                <a href="{{ route('mahasiswa.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('mahasiswa.destroy', $item->id) }}" method="POST" class="d-inline">
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
