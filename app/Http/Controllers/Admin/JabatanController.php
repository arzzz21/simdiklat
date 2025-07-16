<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jabatan;
use App\Models\Unit;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::with('unit')->get();
        $units = Unit::all();
        return view('admin.jabatan.index', compact('jabatans', 'units'));
    }
    public function store(Request $request)
    {
        $request->validate([ 'nama' => 'required|string', 'unit_id' => 'required|exists:units,id', ]);
        Jabatan::create([ 'nama' => $request->nama, 'unit_id' => $request->unit_id, 'is_manajer' => $request->has('is_manajer'), ]);
        return back()->with('success', 'Jabatan berhasil ditambahkan.');
    }
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return back()->with('success', 'Jabatan berhasil dihapus.');
    }
    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'nama' => 'required|string',
            'unit_id' => 'required|exists:units,id',
        ]);
        $jabatan->update([
            'nama' => $request->nama,
            'unit_id' => $request->unit_id,
            'is_manajer' => $request->has('is_manajer'),
        ]);

        return back()->with('success', 'Jabatan berhasil diperbarui.');
    }

}
