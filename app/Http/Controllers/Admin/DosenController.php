<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kampus;
use App\Models\Fakultas;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // tetap jaga autentikasi
    }

    public function index()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Hanya admin yang boleh mengakses.');
        }
        $data = User::role('dosen')->with('kampus')->get();
        return view('admin.dosen.index', compact('data'));
    }

    public function create()
    {
        $kampus = Kampus::all();
        $fakultas = Fakultas::all();
        return view('admin.dosen.create', compact('kampus','fakultas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'kampus_id' => 'required',
            'fakultas_id' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'kampus_id' => $request->kampus_id,
            'fakultas_id' => $request->fakultas,
        ]);

        $user->assignRole('dosen');

        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil ditambahkan.');
    }

    public function edit(User $dosen)
    {
        $kampus = Kampus::all();
        $fakultas = Fakultas::all();
        return view('admin.dosen.edit', compact('dosen', 'kampus','fakultas'));
    }

    public function update(Request $request, User $dosen)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $dosen->id,
            'kampus_id' => 'required',
            'fakultas_id' => 'required',
        ]);

        $dosen->update($request->only('name', 'email', 'kampus_id', 'fakultas'));

        if ($request->filled('password')) {
            $dosen->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil diupdate.');
    }
}
