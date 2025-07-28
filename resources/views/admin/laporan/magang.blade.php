@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Laporan Magang</h4>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.laporan.magang') }}" class="row mb-3">
            <div class="col-md-3">
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.laporan.magang') }}" class="btn btn-secondary">Reset</a>
            </div>
            <div class="col-md-3 text-end">
                <a href="{{ route('admin.laporan.magang.export', request()->all()) }}" class="btn btn-success">Export PDF</a>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Program</th>
                    <th>Dosen</th>
                    <th>Kampus</th>
                    <th>Jumlah Mahasiswa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td>{{ $item->jenisProgram->nama }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->user->kampus->nama ?? '-' }}</td>
                    <td>{{ $item->mahasiswas->count() }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
