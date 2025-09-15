<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
use App\Models\Fakultas;
use App\Models\Kampus;

class ProdiController extends Controller
{
    public function index()
    {
        $query = Prodi::with('fakultas');
        $data = $query->get();
        return view('prodi.index', compact('data'));
    }

    public function create()
    {
        $fakultas = Fakultas::all();
        return view('prodi.create', compact('fakultas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenjang' => 'required',
            'nama' => 'required',
            'fakultas_id' => 'required|exists:fakultas,id'
        ]);
        Prodi::create([
            'jenjang' => $request->jenjang,
            'nama' => $request->nama,
            'fakultas_id' => $request->fakultas_id,
        ]);
        return redirect()->route('prodi.index')->with('success', 'Program Studi ditambahkan');
    }

    public function edit(Prodi $prodi)
    {
        // $this->authorize('update', $mahasiswa); // optional if using policy
        $fakultas = Fakultas::all();
        return view('prodi.edit', compact('prodi', 'fakultas'));
    }

    public function update(Request $request, Prodi $prodi)
    {
        $prodi->update($request->only('fakultas_id', 'nama', 'jenjang'));
        return redirect()->route('prodi.index')->with('success', 'Data diperbarui');
    }

    public function destroy(Prodi $prodi)
    {
        $prodi->delete();
        return redirect()->route('prodi.index')->with('success', 'Data dihapus');
    }
}
