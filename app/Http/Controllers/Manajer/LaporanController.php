<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPelatihan;

class LaporanController extends Controller
{
    public function index()
    {
        // print_r(auth()->user());
        // die();
        $unitId = auth()->user()->pegawai->unit_id;
        $laporans = LaporanPelatihan::whereHas('pegawai', function ($query) use ($unitId) {
            $query->where('unit_id', $unitId);
        })->latest()->get();

        return view('manajer.laporan.index', compact('laporans'));
    }

    public function show(LaporanPelatihan $laporan)
    {
        // validasi manajer hanya boleh melihat laporan dari unit-nya
        if ($laporan->pegawai->unit_id !== auth()->user()->pegawai->unit_id) {
            abort(403);
        }

        return view('manajer.laporan.show', compact('laporan'));
    }

    public function verifikasi(Request $request, LaporanPelatihan $laporan)
    {
        if ($laporan->pegawai->unit_id !== auth()->user()->pegawai->unit_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:revisi,disetujui',
            'catatan' => 'nullable|string',
        ]);

        if ($request->status === 'disetujui') {
            $laporan->status = 'disetujui';
            $laporan->catatan = null;
        } elseif ($request->status === 'revisi') {
            $laporan->status = 'revisi';
            $laporan->catatan = $request->catatan;
        }
        $laporan->tanggal_verifikasi = now();
        $laporan->diverifikasi_oleh = auth()->user()->id;
        $laporan->save();

        return redirect()->route('manajer.laporan.index')->with('success', 'Laporan berhasil diverifikasi.');
    }
}
