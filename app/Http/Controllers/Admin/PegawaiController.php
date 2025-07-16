<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Unit;
use App\Models\Jabatan;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::with('jabatan', 'unit')->get();
        $units = Unit::all();
        $jabatans = Jabatan::all(); return view('admin.pegawai.index', compact('pegawais', 'units', 'jabatans'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nip' => 'nullable|string',
            'unit_id' => 'required|exists:units,id',
            'jabatan_id' => 'required|exists:jabatans,id',
        ]);
        Pegawai::create($request->only('nama', 'nip', 'unit_id', 'jabatan_id'));
        return back()->with('success', 'Pegawai berhasil ditambahkan.');
    }
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return back()->with('success', 'Pegawai berhasil dihapus.');
    }
    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama' => 'required|string',
            'nip' => 'nullable|string',
            'unit_id' => 'required|exists:units,id',
            'jabatan_id' => 'required|exists:jabatans,id',
        ]);
        $pegawai->update($request->only('nama', 'nip', 'unit_id', 'jabatan_id'));

        return back()->with('success', 'Pegawai berhasil diperbarui.');
    }
}
