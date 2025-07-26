<div class="mb-3"> <label>Judul</label> <input type="text" name="judul" value="{{ old('judul', $iht->judul ?? '') }}"
        class="form-control" required> </div>
<div class="mb-3"> <label>Deskripsi</label> <textarea name="deskripsi"
        class="form-control">{{ old('deskripsi', $iht->deskripsi ?? '') }}</textarea> </div>
<div class="mb-3"> <label>Tempat</label> <input type="text" name="tempat"
        value="{{ old('tempat', $iht->tempat ?? '') }}" class="form-control" required> </div>
<div class="mb-3"> <label>Instruktur</label> <input type="text" name="instruktur"
        value="{{ old('instruktur', $iht->instruktur ?? '') }}" class="form-control"> </div>
<div class="mb-3"> <label>Tanggal Mulai</label> <input type="date" name="tanggal_mulai"
        value="{{ old('tanggal_mulai', $iht->tanggal_mulai ?? '') }}" class="form-control" required> </div>
<div class="mb-3"> <label>Tanggal Selesai</label> <input type="date" name="tanggal_selesai"
        value="{{ old('tanggal_selesai', $iht->tanggal_selesai ?? '') }}" class="form-control" required> </div>
<div class="mb-3"> <label>Upload Materi</label> <input type="file" name="file_materi" class="form-control"> </div>
<div class="mb-3"> <label>Upload Dokumentasi</label> <input type="file" name="file_dokumentasi" class="form-control">
</div> <button class="btn btn-success">{{ $submit }}</button> <a href="{{ route('admin.iht.index') }}"
    class="btn btn-secondary">Batal</a>
