<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BerkasPengajuan;

class BerkasController extends Controller
{
    public function index()
    {
        $berkas = BerkasPengajuan::with('pengajuan.user')->orderBy('created_at', 'desc')->get();
        return view('admin.berkas.index', compact('berkas'));
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:valid,invalid',
            'catatan' => 'nullable|string|max:1000'
        ]);
        $berkas = BerkasPengajuan::findOrFail($id);
        $berkas->status_verifikasi = $request->status_verifikasi;
        $berkas->catatan = $request->catatan;
        $berkas->save();

        return back()->with('success', 'Status verifikasi berkas diperbarui.');
    }
}
