<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::all();
        return view('admin.unit.index', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required']);
        Unit::create($request->only('nama'));
        return back()->with('success', 'Unit berhasil ditambahkan.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return back()->with('success', 'Unit berhasil dihapus.');
    }
}
