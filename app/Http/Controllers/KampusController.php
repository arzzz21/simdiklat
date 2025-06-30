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

    public function edit(Kampus $kampus) {
        return view('kampus.edit', compact('kampus'));
    }

    public function update(Request $request, Kampus $kampus) {
        $request->validate(['nama' => 'required']);
        $kampus->update($request->all());
        return redirect()->route('kampus.index')->with('success', 'Data kampus diperbarui');
    }

    public function destroy(Kampus $kampus) {
        $kampus->delete();
        return redirect()->route('kampus.index')->with('success', 'Data kampus dihapus');
    }
}
