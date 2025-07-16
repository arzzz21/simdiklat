<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Unit;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class PegawaiUserController extends Controller
{
    public function createUser(Request $request, Pegawai $pegawai)
    {
        if ($pegawai->user_id) {
        return back()->with('warning', 'Pegawai ini sudah memiliki akun.');
        }
        // Validasi singkat
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $pegawai->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('pegawai');

        $pegawai->user_id = $user->id;
        $pegawai->save();

        return back()->with('success', 'User berhasil dibuat untuk pegawai.');
    }
}
