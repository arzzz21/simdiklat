<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Pelatihan;
use App\Models\Pegawai;
use Illuminate\Support\Str;

class PelatihanController extends Controller
{
    public function index()
    {
        $pelatihans = Pelatihan::with('peserta')->latest()->get();
        return view('admin.pelatihan.index', compact('pelatihans'));
    }

    public function create()
    {
        $pegawais = \App\Models\Pegawai::with('unit')->get();
        return view('admin.pelatihan.create', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tempat' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string',
            'peserta' => 'required|array|min:1',
            'file_info' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama', 'tempat', 'tanggal_mulai', 'tanggal_selesai', 'keterangan']);

        // Simpan file jika ada
        if ($request->hasFile('file_info')) {
            $path = $request->file('file_info')->store('pelatihan_info', 'public');
            // Atur permission file agar bisa dibaca publik
            @chmod(storage_path('app/public/' . $path), 0644);
            $data['file_info'] = $path;
        }

        // Simpan pelatihan dan peserta
        $pelatihan = Pelatihan::create($data);
        $pelatihan->peserta()->sync($request->peserta);

        return redirect()->route('admin.pelatihan.index')->with('success', 'Pelatihan berhasil ditambahkan.');
    }

    public function edit(Pelatihan $pelatihan)
    {
        $pegawais = \App\Models\Pegawai::with('unit')->get();
        return view('admin.pelatihan.edit', compact('pelatihan', 'pegawais'));
    }

    public function update(Request $request, Pelatihan $pelatihan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tempat' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string',
            'peserta' => 'required|array|min:1',
            'file_info' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama', 'tempat', 'tanggal_mulai', 'tanggal_selesai', 'keterangan']);

        // Ganti file jika diupload
        if ($request->hasFile('file_info')) {
            // Hapus file lama jika ada
            if ($pelatihan->file_info && Storage::exists('public/' . $pelatihan->file_info)) {
                Storage::delete('public/' . $pelatihan->file_info);
            }

            // Simpan file baru
            $path = $request->file('file_info')->store('pelatihan_info', 'public');
            $data['file_info'] = $path;
        }

        $pelatihan->update($data);
        $pelatihan->peserta()->sync($request->peserta);

        return redirect()->route('admin.pelatihan.index')->with('success', 'Pelatihan berhasil diperbarui.');
    }
    public function destroy(Pelatihan $pelatihan)
    {
        // Hapus file_info jika ada
        if ($pelatihan->file_info && Storage::exists('public/' . $pelatihan->file_info)) {
            Storage::delete('public/' . $pelatihan->file_info);
        }

        // Hapus relasi peserta
        $pelatihan->peserta()->detach();

        // Hapus data pelatihan
        $pelatihan->delete();

        return redirect()->route('admin.pelatihan.index')->with('success', 'Pelatihan berhasil dihapus.');
    }

}
