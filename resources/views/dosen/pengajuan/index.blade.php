@extends('layouts.master') @section('title', 'Daftar Pengajuan') @section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pengajuan</h5>
        <a href="{{ route('dosen.pengajuan.create') }}" class="btn btn-primary">+ Buat Pengajuan</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuans as $item)
                    <tr>
                        <td>{{ $item->jenisProgram->nama }}</td>
                        <td>{{ $item->tanggal_mulai }} s.d. {{ $item->tanggal_selesai }}</td>
                        <td>
                            <span class="badge bg-{{ $item->status == 'ditolak' ? 'danger' : ($item->status == 'diajukan' ? 'warning' : 'success') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}">
                            Lihat
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Pengajuan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Jenis Program:</strong> {{ $item->jenisProgram->nama }}</p>
                                    <p><strong>Program Studi:</strong> {{ $item->program_studi }}</p>
                                    <p><strong>Tanggal:</strong> {{ $item->tanggal_mulai }} s/d {{ $item->tanggal_selesai }}</p>
                                    <p><strong>Status:</strong> {{ $item->status }}</p>
                                    <p><strong>Mahasiswa:</strong></p>
                                    <ul>
                                    @foreach($item->mahasiswas as $mhs)
                                        <li>{{ $mhs->nama }} ({{ $mhs->nim }})</li>
                                    @endforeach
                                    </ul>
                                </div>
                                </div>
                            </div>
                            </div>
                            <a href="{{ route('dosen.pengajuan.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
