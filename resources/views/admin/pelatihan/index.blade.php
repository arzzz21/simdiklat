@extends('layouts.master')
@section('title', 'Daftar Pelatihan')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Daftar Pelatihan</h5> <a href="{{ route('admin.pelatihan.create') }}" class="btn btn-primary">+
            Tambah Pelatihan</a>
    </div>
    <div class="card-body"> @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Tempat</th>
                    <th>Tanggal</th>
                    <th>Peserta</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pelatihans as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->tempat }}</td>
                    <td>{{ $item->tanggal_mulai }} s/d {{ $item->tanggal_selesai }}</td>
                    <td>
                        <ul class="mb-0">
                            @foreach ($item->peserta as $p)
                            <li>{{ $p->nama }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="{{ route('admin.pelatihan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.pelatihan.destroy', $item->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div> @endsection
