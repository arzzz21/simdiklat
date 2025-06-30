@extends('layouts.master')
@section('title', 'Edit Pengajuan')

@section('content')

<div class="card">
    <div class="card-header">
        <h5>Edit Pengajuan PKL/Magang</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('dosen.pengajuan.update', $pengajuan->id) }}" method="POST"> @csrf @method('PUT')
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mb-3">
                <label>Jenis Program</label>
                <select name="jenis_program_id" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    @foreach($jenis_programs as $jp)
                    <option value="{{ $jp->id }}" {{ $pengajuan->jenis_program_id == $jp->id ? 'selected' : '' }}>
                        {{ $jp->nama }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Program Studi --}}
            <div class="mb-3">
                <label for="program_studi">Program Studi</label>
                <input type="text" name="program_studi" class="form-control" value="{{ $pengajuan->program_studi }}" required>
            </div>

            <div class="mb-3">
                <label>Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="{{ $pengajuan->tanggal_mulai }}"
                    required>
            </div>

            <div class="mb-3">
                <label>Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" value="{{ $pengajuan->tanggal_selesai }}"
                    required>
            </div>

            <div class="mb-3">
                <label>Tambah Mahasiswa</label>
                <div class="d-flex gap-2">
                    <select id="mahasiswa-select" class="form-control" style="width: 100%">
                        <option value="">-- Cari Mahasiswa --</option>
                        @foreach($mahasiswas as $mhs)
                        <option value="{{ $mhs->id }}">{{ $mhs->nama }} ({{ $mhs->nim }})</option>
                        @endforeach
                    </select>
                    <button type="button" id="btn-tambah" class="btn btn-primary">Tambahkan</button>
                </div>
                <small class="text-muted">Cari mahasiswa lalu klik “Tambahkan”.</small>
            </div>

            <div class="mb-3">
                <label>Daftar Mahasiswa Terpilih:</label>
                <ul id="mahasiswa-list" class="list-group mb-2">
                    @foreach($pengajuan->mahasiswas as $mhs)
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        id="mhs-item-{{ $mhs->id }}">
                        {{ $mhs->nama }} ({{ $mhs->nim }})
                        <button type="button" class="btn btn-danger btn-sm remove-mahasiswa"
                            data-id="{{ $mhs->id }}">Hapus</button>
                    </li>
                    <input type="hidden" name="mahasiswa_ids[]" value="{{ $mhs->id }}" id="mhs-input-{{ $mhs->id }}">
                    @endforeach
                </ul>
            </div>

            <div id="mahasiswa-hidden-inputs"></div>

            <button type="submit" class="btn btn-success">Perbarui Pengajuan</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
{{-- Select2 --}}

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
                $('#mahasiswa-select').select2();
                $('#btn-tambah').on('click', function () {
                    const selectedId = $('#mahasiswa-select').val();
                    const selectedText = $('#mahasiswa-select option:selected').text();
                    if (!selectedId) return;
                    if ($('#mhs-item-' + selectedId).length === 0) {
                        $('#mahasiswa-list').append(
                            ` <li class="list-group-item d-flex justify-content-between align-items-center" id="mhs-item-${selectedId}"> ${selectedText} <button type="button" class="btn btn-danger btn-sm remove-mahasiswa" data-id="${selectedId}">Hapus</button> </li> `
                            );
                        $('#mahasiswa-hidden-inputs').append(
                            ` <input type="hidden" name="mahasiswa_ids[]" value="${selectedId}" id="mhs-input-${selectedId}"> `
                            );
                    }
                    // reset
                    select $('#mahasiswa-select').val(null).trigger('change');
                });
                $(document).on('click', '.remove-mahasiswa', function () {
                    const id = $(this).data('id'); $('#mhs-item-' + id).remove();
                    $('#mhs-input-' + id).remove();
                });
            });

</script>
@endpush
