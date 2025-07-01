<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;

class BerkasController extends Controller
{
    public function index($id)
    {
        $pengajuan = Pengajuan::with('berkas')->where('user_id', auth()->id())->findOrFail($id);
        return view('dosen.pengajuan.berkas', compact('pengajuan'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'nama_berkas' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $pengajuan = Pengajuan::where('user_id', auth()->id())->findOrFail($id);

        $path = $request->file('file')->store('berkas_pengajuan', 'public');

        $pengajuan->berkas()->create([
            'nama_berkas' => $request->nama_berkas,
            'file' => $path,
        ]);

        return back()->with('success', 'Berkas berhasil diunggah.');
    }

    public function destroy($id)
    {
        $berkas = BerkasPengajuan::findOrFail($id);

        if ($berkas->pengajuan->user_id != auth()->id()) {
            abort(403);
        }

        Storage::disk('public')->delete($berkas->file);
        $berkas->delete();

        return back()->with('success', 'Berkas berhasil dihapus.');
    }

}
