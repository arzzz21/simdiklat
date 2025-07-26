@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <h4>Presensi dan Upload Materi: {{ $iht->judul }}</h4>
    <form action="{{ route('admin.iht.presensi.simpan', $iht->id) }}" method="POST" enctype="multipart/form-data"> @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Peserta</th>
                    <th>Hadir</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($iht->pesertas as $peserta)
                <tr>
                    <td>{{ $peserta->pegawai->nama }}</td>
                    <td>
                        <input type="checkbox" name="hadir[]" value="{{ $peserta->id }}"
                            {{ $peserta->hadir ? 'checked' : '' }}>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="form-group mt-3">
            <label for="materi_file">Upload Materi (PDF atau ZIP):</label>
            <input type="file" name="materi_file" class="form-control" accept=".pdf,.zip">
            @if ($iht->materi_file)
            <p class="mt-2">File saat ini: <a href="{{ asset('storage/' . $iht->materi_file) }}" target="_blank">Lihat
                    Materi</a></p>
            @endif
        </div>

        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('admin.iht.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div> @endsection
