@extends('layouts.master') @section('title', 'Pegawai') @section('content') <div class="card">
    <div class="card-header">
        <h5>Data Pegawai</h5>
    </div>
    <div class="card-body"> @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div>
        @endif <form method="POST" action="{{ route('admin.pegawai.store') }}" class="row g-3 mb-3"> @csrf <div
                class="col-md-3"> <input type="text" name="nama" class="form-control" placeholder="Nama Pegawai"
                    required> </div>
            <div class="col-md-2"> <input type="text" name="nip" class="form-control" placeholder="NIP"> </div>
            <div class="col-md-3"> <select name="unit_id" class="form-select" required>
                    <option value="">-- Pilih Unit --</option> @foreach($units as $unit) <option
                        value="{{ $unit->id }}">{{ $unit->nama }}</option> @endforeach
                </select> </div>
            <div class="col-md-3"> <select name="jabatan_id" class="form-select" required>
                    <option value="">-- Pilih Jabatan --</option> @foreach($jabatans as $jab) <option
                        value="{{ $jab->id }}">{{ $jab->nama }}</option> @endforeach
                </select> </div>
            <div class="col-md-1"> <button class="btn btn-primary w-100">+ Tambah</button> </div>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Unit</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                    <th>Akun</th>
                </tr>
            </thead>
            <tbody> @foreach ($pegawais as $pgw) <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pgw->nama }}</td>
                    <td>{{ $pgw->nip ?? '-' }}</td>
                    <td>{{ $pgw->unit->nama ?? '-' }}</td>
                    <td>{{ $pgw->jabatan->nama ?? '-' }}</td>
                    <td>
                        {{-- Tombol Edit --}}
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editPegawai{{ $pgw->id }}">Edit</button>

                        {{-- Tombol Hapus --}}
                        <form method="POST" action="{{ route('admin.pegawai.destroy', $pgw->id) }}"
                            onsubmit="return confirm('Hapus data ini?')"> @csrf @method('DELETE') <button
                                class="btn btn-sm btn-danger">Hapus</button> </form>
                        {{-- Modal Edit --}}

                        <div class="modal fade" id="editPegawai{{ $pgw->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form class="modal-content" method="POST"
                                    action="{{ route('admin.pegawai.update', $pgw->id) }}"> @csrf @method('PUT') <div
                                        class="modal-header">
                                        <h5 class="modal-title">Edit Pegawai</h5> <button type="button"
                                            class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2"> <label>Nama</label> <input type="text" name="nama"
                                                class="form-control" value="{{ $pgw->nama }}" required> </div>
                                        <div class="mb-2"> <label>NIP</label> <input type="text" name="nip"
                                                class="form-control" value="{{ $pgw->nip }}"> </div>
                                        <div class="mb-2"> <label>Unit</label> <select name="unit_id"
                                                class="form-select" required> @foreach($units as $unit) <option
                                                    value="{{ $unit->id }}"
                                                    {{ $pgw->unit_id == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->nama }} </option> @endforeach </select> </div>
                                        <div class="mb-2"> <label>Jabatan</label> <select name="jabatan_id"
                                                class="form-select" required> @foreach($jabatans as $jab) <option
                                                    value="{{ $jab->id }}"
                                                    {{ $pgw->jabatan_id == $jab->id ? 'selected' : '' }}>
                                                    {{ $jab->nama }} </option> @endforeach </select> </div>
                                    </div>
                                    <div class="modal-footer"> <button class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button> <button
                                            class="btn btn-primary">Simpan</button> </div>
                                </form>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if (!$pgw->user_id)
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalBuatUser{{ $pgw->id }}">Buat User</button>
                            <!-- Modal -->
                            <div class="modal fade" id="modalBuatUser{{ $pgw->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.pegawaiuser.createUser', $pgw->id) }}" method="POST" class="modal-content">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Buat Akun untuk {{ $pgw->nama }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                                </form>
                            </div>
                            </div>
                        @else <span class="badge bg-success">Sudah Ada</span><br> <small>{{ $pgw->user->email }}</small> @endif
                    </td>
                </tr> @endforeach
            </tbody>
        </table>
    </div>
</div> @endsection
