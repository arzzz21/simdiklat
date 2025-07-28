@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Laporan Pelatihan Luar RS</h4>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.laporan.pelatihan') }}" class="row g-3">
            <div class="col-md-3">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" required>
            </div>
            <div class="col-md-3">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" required>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.laporan.pelatihan.export', request()->all()) }}" class="btn btn-success">Export PDF</a>
            </div>
        </form>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>Tempat</th>
                    <th>Peserta</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->tanggal_mulai }} s/d {{ $item->tanggal_selesai }}</td>
                    <td>{{ $item->tempat }}</td>
                    <td>
                        @foreach($item->peserta as $p)
                            <div>{{ $p->nama }}</div>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
