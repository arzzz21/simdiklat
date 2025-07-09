<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::with('user', 'jenisProgram', 'invoice')->orderBy('created_at', 'desc')->get();
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
        $pengajuan->unit_magang = $request->status == 'diterima' ? $request->unit_magang : null;
        $pengajuan->pembimbing_rumah_sakit = $request->status == 'diterima' ? $request->pembimbing_rumah_sakit : null;
        $pengajuan->nip_pembimbing = $request->status == 'diterima' ? $request->nip_pembimbing : null;
        $pengajuan->jabatan_pembimbing = $request->status == 'diterima' ? $request->jabatan_pembimbing : null;
        $pengajuan->save();

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan telah diverifikasi.');
    }
    public function verifikasiIndex()
    {
        // $pengajuans = Pengajuan::with('user', 'jenisProgram')
        //     ->where('status', 'diterima')
        //     ->latest()->get();

        // return view('admin.pengajuan.verifikasi_index', compact('pengajuans'));

        $belumDiverifikasi = Pengajuan::with('user', 'jenisProgram')
            ->where('status', 'diterima')
            ->latest()
            ->get();
        $sudahDiverifikasi = Pengajuan::with('user', 'jenisProgram')
            ->whereIn('status', ['terverifikasi', 'invoice_diterbitkan', 'menunggu_verifikasi_pembayaran', 'selesai', 'berkas_tidak_sesuai'])
            ->latest()
            ->get();

        return view('admin.pengajuan.verifikasi_index', compact('belumDiverifikasi', 'sudahDiverifikasi'));
    }

    public function verifikasiForm($id)
    {
        $pengajuan = Pengajuan::with('user', 'jenisProgram', 'berkas')->findOrFail($id);
        return view('admin.pengajuan.verifikasi_form', compact('pengajuan'));
    }

    public function verifikasiBerkas(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:terverifikasi,invoice_diterbitkan,menunggu_verifikasi_pembayaran,selesai,berkas_tidak_sesuai',
            'catatan_berkas' => 'nullable|string',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->status = $request->status;
        $pengajuan->catatan_berkas = $request->catatan_berkas;
        $pengajuan->save();

        return redirect()->route('admin.pengajuan.verifikasi.index')->with('success', 'Pengajuan berhasil diverifikasi.');
    }
}
