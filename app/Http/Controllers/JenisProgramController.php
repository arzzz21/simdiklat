<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisProgram;

class JenisProgramController extends Controller
{
    public function index()
    {
        $data = JenisProgram::all();
        return view('jenis_program.index', compact('data'));
    }

    public function create()
    {
        return view('jenis_program.create');
    }

    public function store(Request $request)
    {
        JenisProgram::create($request->all());
        return redirect()->route('jenis-program.index')->with('success', 'Berhasil menambahkan.');
    }

    public function edit(JenisProgram $jenisProgram)
    {
        return view('jenis_program.edit', compact('jenisProgram'));
    }

    public function update(Request $request, JenisProgram $jenisProgram)
    {
        $jenisProgram->update($request->all());
        return redirect()->route('jenis-program.index')->with('success', 'Berhasil diperbarui.');
    }

    public function destroy(JenisProgram $jenisProgram)
    {
        $jenisProgram->delete();
        return back()->with('success', 'Berhasil dihapus.');
    }
}
