@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <h4>Peserta IHT: {{ $iht->judul }}</h4>
    <form action="{{ route('admin.iht.peserta.tambah', $iht->id) }}" method="POST" class="row g-2 mb-3">
        @csrf
        <div class="col-md-6">
            <select name="pegawai_id" class="form-control" required>
                <option value="">-- Pilih Pegawai --</option>
                @foreach($pegawai_all as $p)
                <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->nip }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">+ Tambah</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIP</th>
                <th>Hadir</th>
                <th>Evaluasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peserta_terdaftar as $peserta)
            <tr>
                <td>{{ $peserta->pegawai->nama }}</td>
                <td>{{ $peserta->pegawai->nip }}</td>
                <td>{{ $peserta->hadir ? '✔' : '✘' }}</td>
                <td>{{ $peserta->evaluasi }}</td>
                <td>
                    <form action="{{ route('admin.iht.peserta.hapus', [$iht->id, $peserta->id]) }}" method="POST"
                        onsubmit="return confirm('Hapus peserta ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.iht.index') }}" class="btn btn-secondary">Kembali</a>
</div> @endsection
