@extends('layouts.master') @section('title', 'Jabatan') @section('content') <div class="card">
    <div class="card-header">
        <h5>Data Jabatan</h5>
    </div>
    <div class="card-body"> @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div>
        @endif <form method="POST" action="{{ route('admin.jabatan.store') }}" class="row g-3 mb-3"> @csrf <div
                class="col-md-4"> <input type="text" name="nama" class="form-control" placeholder="Nama Jabatan"
                    required> </div>
            <div class="col-md-3"> <select name="unit_id" class="form-select" required>
                    <option value="">-- Pilih Unit --</option> @foreach($units as $unit) <option
                        value="{{ $unit->id }}">{{ $unit->nama }}</option> @endforeach
                </select> </div>
            <div class="col-md-2">
                <div class="form-check mt-2"> <input class="form-check-input" type="checkbox" name="is_manajer"
                        id="is_manajer"> <label class="form-check-label" for="is_manajer">Manajer?</label> </div>
            </div>
            <div class="col-md-3"> <button class="btn btn-primary w-100">+ Tambah</button> </div>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Jabatan</th>
                    <th>Unit</th>
                    <th>Manajer?</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody> @foreach ($jabatans as $jab) <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jab->nama }}</td>
                    <td>{{ $jab->unit->nama ?? '-' }}</td>
                    <td>{!! $jab->is_manajer ? '<span class="badge bg-success">Ya</span>' : '<span
                            class="badge bg-secondary">Tidak</span>' !!}</td>
                    <td>
                        {{-- Tombol Edit --}}
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editJabatan{{ $jab->id }}">Edit</button>
                        {{-- TOmbol Hapus --}}
                        <form method="POST" action="{{ route('admin.jabatan.destroy', $jab->id) }}"
                            onsubmit="return confirm('Hapus data ini?')"> @csrf @method('DELETE') <button
                                class="btn btn-sm btn-danger">Hapus</button> </form>

                        <div class="modal fade" id="editJabatan{{ $jab->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form class="modal-content" method="POST"
                                    action="{{ route('admin.jabatan.update', $jab->id) }}"> @csrf @method('PUT') <div
                                        class="modal-header">
                                        <h5 class="modal-title">Edit Jabatan</h5> <button type="button"
                                            class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2"> <label>Nama Jabatan</label> <input type="text" name="nama"
                                                class="form-control" value="{{ $jab->nama }}" required> </div>
                                        <div class="mb-2"> <label>Unit</label> <select name="unit_id"
                                                class="form-select" required> @foreach($units as $unit) <option
                                                    value="{{ $unit->id }}"
                                                    {{ $jab->unit_id == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->nama }} </option> @endforeach </select> </div>
                                        <div class="form-check"> <input class="form-check-input" type="checkbox"
                                                name="is_manajer" id="check{{ $jab->id }}"
                                                {{ $jab->is_manajer ? 'checked' : '' }}> <label class="form-check-label"
                                                for="check{{ $jab->id }}">Manajer?</label> </div>
                                    </div>
                                    <div class="modal-footer"> <button class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button> <button
                                            class="btn btn-primary">Simpan</button> </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr> @endforeach </tbody>
        </table>
    </div>
</div> @endsection
