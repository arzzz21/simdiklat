<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $pengajuan = Pengajuan::with('invoice', 'jenisProgram')->findOrFail($id);
        return view('dosen.invoice.show', compact('pengajuan'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $pengajuan = Pengajuan::with('invoice')->findOrFail($id);
        $invoice = $pengajuan->invoice;

        if ($invoice->bukti_pembayaran) {
            Storage::delete('public/' . $invoice->bukti_pembayaran);
        }

        $path = $request->file('bukti')->store('bukti_pembayaran', 'public');

        $invoice->update([
            'bukti_pembayaran' => $path,
            'status' => 'menunggu_verifikasi',
        ]);

        $pengajuan->update([
            'status' => 'menunggu_verifikasi_pembayaran'
        ]);

        //return back()->with('success', 'Bukti pembayaran berhasil diunggah.');\
        return redirect()->route('dosen.pengajuan.index')->with('success', 'Bukti pembayaran berhasil diunggah.');
    }
    public function cetakPDF($id)
    {
        $invoice = \App\Models\Invoice::with('pengajuan.jenisProgram', 'pengajuan.user')->findOrFail($id);

        $pdf = Pdf::loadView('dosen.invoice.cetak', compact('invoice'))->setPaper('A4');

        return $pdf->stream('invoice-'.$invoice->id.'.pdf');
        // Bisa pakai ->download(...) kalau ingin langsung download
    }
}
