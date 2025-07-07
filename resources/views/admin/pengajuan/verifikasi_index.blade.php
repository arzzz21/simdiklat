@extends('layouts.master')
@section('title', 'Verifikasi Pengajuan')

@section('content')

<div class="card">
    <div class="card-header">
        <h5>Pengajuan Belum Diverifikasi</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Dosen</th>
                    <th>Program</th>
                    <th>Periode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($belumDiverifikasi as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->user->name }}</td>
                    <td>{{ $p->jenisProgram->nama }}</td>
                    <td>{{ $p->tanggal_mulai }} - {{ $p->tanggal_selesai }}</td>
                    <td>
                        <a href="{{ route('admin.pengajuan.verifikasi.form', $p->id) }}" class="btn btn-primary btn-sm">Verifikasi</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="card mt-4">
    <div class="card-header">
        <h5>Pengajuan yang Sudah Diverifikasi</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Dosen</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th>Tanggal Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sudahDiverifikasi as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->user->name }}</td>
                    <td>
                        @php
                            $statusTerverifikasi = ['terverifikasi', 'invoice_diterbitkan', 'menunggu_verifikasi_pembayaran', 'selesai'];
                        @endphp

                        @if(in_array($p->status, $statusTerverifikasi))
                            <span class="badge bg-success">Terverifikasi</span>
                        @else
                            <span class="badge bg-danger">Berkas Tidak Sesuai</span>
                        @endif
                    </td>
                    <td>{{ $p->catatan_berkas }}</td>
                    <td>
                        {{ $p->updated_at->format('Y-m-d H:i') }} &nbsp;
                        @if($p->status == 'berkas_tidak_sesuai')
                        <a href="{{ route('admin.pengajuan.verifikasi.form', $p->id) }}" class="btn btn-primary btn-sm">Verifikasi Ulang</a>
                        @endif
                    </td>
                </tr> @empty <tr>
                    <td colspan="4">Belum ada verifikasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
