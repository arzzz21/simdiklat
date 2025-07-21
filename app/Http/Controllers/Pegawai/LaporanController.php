<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelatihan;
use App\Models\LaporanPelatihan;
use Illuminate\Support\Facades\Validator;

class LaporanController extends Controller
{
    public function create(Pelatihan $pelatihan)
    {
        return view('pegawai.laporan.create', compact('pelatihan'));
    }

    public function store(Request $request, $pelatihan)
    {
        $validator = Validator::make($request->all(), [
            'ringkasan'         => 'required|string',
            'rtl'               => 'required|array',
            'rtl.*'             => 'required|string',
            'file_laporan'      => 'required|file|mimes:pdf|max:2048',
            'file_surat_tugas'  => 'required|file|mimes:pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pegawai = auth()->user()->pegawai;

        LaporanPelatihan::create([
            'pelatihan_id' => $pelatihan,
            'pegawai_id' => $pegawai->id,
            'ringkasan' => $request->ringkasan,
            'rtl' => $request->rtl,
            'file_laporan' => $request->file('file_laporan')->store('laporan', 'public'),
            'file_surat_tugas' => $request->file('file_surat_tugas')->store('surat_tugas', 'public'),
            'status' => 'diajukan',
        ]);

        return redirect()->route('pegawai.dashboard')->with('success', 'Laporan berhasil dikirim.');
    }
    public function show(LaporanPelatihan $laporan)
    {
        // Pastikan hanya pegawai yang bersangkutan yang bisa melihat
        $pegawai = auth()->user()->pegawai;
        if ($laporan->pegawai_id !== $pegawai->id) {
            abort(403);
        }

        return view('pegawai.laporan.show', compact('laporan'));
    }
    public function edit(LaporanPelatihan $laporan)
    {
        if ($laporan->status !== 'revisi') {
            abort(403, 'Laporan hanya bisa diedit jika statusnya revisi.');
        }
        // $laporan = LaporanPelatihan::where('id', $laporan)
        //             ->where('pegawai_id', auth()->user()->pegawai->id)
        //             ->where('status', 'revisi')
        //             ->firstOrFail();

        return view('pegawai.laporan.edit', compact('laporan'));
    }
    public function update(Request $request, LaporanPelatihan $laporan)
    {
        if ($laporan->status !== 'revisi') {
            abort(403, 'Laporan hanya bisa diperbarui jika statusnya revisi.');
        }

        $validator = Validator::make($request->all(), [
            'ringkasan'         => 'required|string',
            'rtl'               => 'required|array',
            'rtl.*'             => 'required|string',
            'file_laporan'      => 'file|mimes:pdf|max:2048',
            'file_surat_tugas'  => 'file|mimes:pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $laporan->ringkasan = $request->ringkasan;
        $laporan->rtl = $request->rtl;

        if ($request->hasFile('file_laporan')) {
            $laporan->file_laporan = $request->file('file_laporan')->store('laporan', 'public');
        }
        if ($request->hasFile('file_surat_tugas')) {
            $laporan->file_surat_tugas = $request->file('file_surat_tugas')->store('surat-tugas', 'public');
        }

        $laporan->status = 'diajukan'; // reset status
        $laporan->catatan = null;
        $laporan->tanggal_verifikasi = null;
        $laporan->diverifikasi_oleh = null;

        $laporan->save();

        return redirect()->route('pegawai.dashboard')->with('success', 'Laporan berhasil diperbarui dan dikirim ulang.');
    }

}
