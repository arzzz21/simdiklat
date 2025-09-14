<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fakultas;
use App\Models\Kampus;

class FakultasController extends Controller
{
    public function index()
    {
        $query = Fakultas::with('kampus');
        $data = $query->get();
        return view('fakultas.index', compact('data'));
    }

    public function create()
    {
        $kampus = Kampus::all();
        return view('fakultas.create', compact('kampus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kampus_id' => 'required|exists:kampus,id'
        ]);
        Fakultas::create([
            'nama' => $request->nama,
            'kampus_id' => $request->kampus_id,
        ]);
        return redirect()->route('fakultas.index')->with('success', 'Fakultas ditambahkan');
    }

    public function edit(Fakultas $fakulta)
    {
        // $this->authorize('update', $mahasiswa); // optional if using policy
        $kampus = Kampus::all();
        return view('fakultas.edit', compact('fakulta', 'kampus'));
    }

    public function update(Request $request, Fakultas $fakulta)
    {
        $fakulta->update($request->only('kampus_id', 'nama'));
        return redirect()->route('fakultas.index')->with('success', 'Data diperbarui');
    }

    public function destroy(Fakultas $fakulta)
    {
        $fakulta->delete();
        return redirect()->route('fakultas.index')->with('success', 'Data dihapus');
    }
}
