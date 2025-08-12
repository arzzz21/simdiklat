<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kampus;

class KampusController extends Controller
{
    public function index() {
        $data = Kampus::all();
        return view('kampus.index', compact('data'));
    }

    public function create() {
        return view('kampus.create');
    }

    public function store(Request $request) {
        $request->validate(['nama' => 'required']);
        Kampus::create($request->all());
        return redirect()->route('kampus.index')->with('success', 'Data kampus ditambahkan');
    }

    public function edit(Kampus $kampu) {
        return view('kampus.edit', compact('kampu'));
    }

    public function update(Request $request, Kampus $kampu) {
        $request->validate(['nama' => 'required']);
        $kampu->update($request->all());
        return redirect()->route('kampus.index')->with('success', 'Data kampus diperbarui');
    }

    public function destroy(Kampus $kampu) {
        $kampu->delete();
        return back()->with('success', 'Data Kampus Berhasil dihapus.');
    }
}
