<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;
use App\Models\JenisProgram;
use App\Models\Mahasiswa;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::where('user_id', Auth::id())
            ->with('jenisProgram')
            ->latest()
            ->get();
        return view('dosen.pengajuan.index', compact('pengajuans'));
    }
    public function create()
    {
        $jenis_programs = JenisProgram::all();
        $mahasiswas = Mahasiswa::where('user_id', Auth::id())->get();
        return view('dosen.pengajuan.create', compact('jenis_programs', 'mahasiswas'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'jenis_program_id' => 'required|exists:jenis_programs,id',
            'program_studi' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'mahasiswa_ids' => 'required|array|min:1',
            'mahasiswa_ids.*' => 'exists:mahasiswas,id',
        ]);

        // Simpan pengajuan
        $pengajuan = Pengajuan::create([
            'user_id' => auth()->id(), // atau dari relasi dosen
            'jenis_program_id' => $request->jenis_program_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => 'diajukan', // default status
        ]);

        // Simpan relasi mahasiswa ke tabel pivot
        $pengajuan->mahasiswas()->attach($request->mahasiswa_ids);

        return redirect()->route('dosen.pengajuan.index')->with('success', 'Pengajuan berhasil disimpan.');
    }
    public function edit($id)
    {
        $pengajuan = Pengajuan::with('mahasiswas')->findOrFail($id);
        $jenis_programs = JenisProgram::all();
        $mahasiswas = Mahasiswa::where('user_id', auth()->id())->get();
        return view('dosen.pengajuan.edit', compact('pengajuan', 'jenis_programs', 'mahasiswas'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_program_id' => 'required|exists:jenis_programs,id',
            'program_studi' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'mahasiswa_ids' => 'required|array|min:1',
            'mahasiswa_ids.*' => 'exists:mahasiswas,id',
        ]);
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update([
            'jenis_program_id' => $request->jenis_program_id,
            'program_studi' => $request->program_studi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => 'diajukan', // bisa disesuaikan
        ]);

        // Update relasi mahasiswa
        $pengajuan->mahasiswas()->sync($request->mahasiswa_ids);

        return redirect()->route('dosen.pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui.');
    }


}
