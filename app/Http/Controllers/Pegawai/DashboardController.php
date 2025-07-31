<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Pegawai;

class DashboardController extends Controller
{
    public function indexPegawai()
    {
        $pegawai = Auth::user()->pegawai;

        // Cek apakah user sudah terhubung ke pegawai
        if (!$pegawai) {
            return redirect()->route('dashboard')->with('error', 'Akun Anda belum terhubung ke data pegawai.');
        }

        // Ambil semua pelatihan yang diikuti pegawai
        $pelatihans = $pegawai->pelatihans()->latest()->get();

        return view('pegawai.dashboard', compact('pegawai', 'pelatihans'));
    }
}
