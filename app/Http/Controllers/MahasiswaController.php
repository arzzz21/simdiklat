<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Kampus;
use App\Models\Fakultas;
use App\Models\Prodi;

class MahasiswaController extends Controller
{
    public function index()
    {
        $query = Mahasiswa::with('kampus', 'prodi');
        if (auth()->user()->hasRole('dosen')) {
            $query->where('user_id', auth()->id());
        }
        $data = $query->get();
        return view('mahasiswa.index', compact('data'));
    }

    public function create()
    {
        $kampus = Kampus::all();
        $prodi = Prodi::all();
        return view('mahasiswa.create', compact('kampus', 'prodi'));
    }

    public function store(Request $request)
    {
        // print_r($request->all());
        // die();
        $request->validate([
            'nama' => 'required', 'nim' => 'required',
            'kampus_id' => 'required|exists:kampus,id'
        ]);
        Mahasiswa::create([
            'user_id' => auth()->id(),
            'kampus_id' => $request->kampus_id,
            'nama' => $request->nama,
            'nim' => $request->nim,
            'prodi_id' => $request->prodi_id,
            'no_hp' => $request->no_hp,
        ]);
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa ditambahkan');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        // $this->authorize('update', $mahasiswa); // optional if using policy
        $kampus = Kampus::all();
        $prodi = Prodi::all();
        return view('mahasiswa.edit', compact('mahasiswa', 'kampus', 'prodi'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $mahasiswa->update($request->only('kampus_id', 'nama', 'nim', 'prodi_id', 'no_hp'));
        return redirect()->route('mahasiswa.index')->with('success', 'Data diperbarui');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Data dihapus');
    }

    public function getProdiByKampus($kampus_id)
    {
        $prodi = Prodi::whereIn('fakultas_id', function ($q) use ($kampus_id) {
            $q->select('id')->from('fakultas')->where('kampus_id', $kampus_id);
        })->get();
        return response()->json($prodi);
    }
}
