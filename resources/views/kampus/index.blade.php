@extends('layouts.master')
@section('title', 'Data Kampus')
@section('content')
    <h4>Data Kampus</h4>
    <a href="{{ route('kampus.create') }}" class="btn btn-primary mb-2">Tambah Kampus</a>
    <table class="table">
        <thead>
            <tr><th>#</th><th>Nama</th><th>Alamat</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>
                        <a href="{{ route('kampus.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('kampus.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf 
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
