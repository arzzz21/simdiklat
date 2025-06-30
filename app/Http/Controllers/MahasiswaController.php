<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Kampus;

class MahasiswaController extends Controller
{
    public function index()
    {
        $query = Mahasiswa::with('kampus');
        if (auth()->user()->hasRole('dosen')) {
            $query->where('user_id', auth()->id());
        }
        $data = $query->get();
        return view('mahasiswa.index', compact('data'));
    }

    public function create()
    {
        $kampus = Kampus::all();
        return view('mahasiswa.create', compact('kampus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required', 'nim' => 'required',
            'kampus_id' => 'required|exists:kampus,id'
        ]);
        Mahasiswa::create([
            'user_id' => auth()->id(),
            'kampus_id' => $request->kampus_id,
            'nama' => $request->nama,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'no_hp' => $request->no_hp,
        ]);
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa ditambahkan');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $this->authorize('update', $mahasiswa); // optional if using policy
        $kampus = Kampus::all();
        return view('mahasiswa.edit', compact('mahasiswa', 'kampus'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $mahasiswa->update($request->only('kampus_id', 'nama', 'nim', 'prodi', 'no_hp'));
        return redirect()->route('mahasiswa.index')->with('success', 'Data diperbarui');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Data dihapus');
    }
}
