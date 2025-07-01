<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::with('user', 'jenisProgram')->orderBy('created_at', 'desc')->get();
        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'alasan' => 'nullable|string|max:500',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->status = $request->status;
        $pengajuan->diverifikasi_oleh = auth()->id();
        $pengajuan->tanggal_verifikasi = now();
        $pengajuan->alasan_ditolak = $request->status == 'ditolak' ? $request->alasan : null;
        $pengajuan->save();

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan telah diverifikasi.');
    }

}
