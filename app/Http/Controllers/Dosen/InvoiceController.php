<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $invoice = \App\Models\Invoice::with('pengajuan.jenisProgram', 'pengajuan.user', 'pengajuan.mahasiswas')->findOrFail($id);

        $pdf = Pdf::loadView('dosen.invoice.cetak', compact('invoice'))->setPaper('A4');

        return $pdf->stream('invoice-'.$invoice->id.'.pdf');
        // Bisa pakai ->download(...) kalau ingin langsung download
    }
    public function cetakKuitansi($id)
    {
        $pengajuan = Pengajuan::with(['invoice', 'user', 'jenisProgram', 'mahasiswas', 'verifikator'])
                    ->findOrFail($id);

        if (!$pengajuan->invoice) {
            abort(404, 'Invoice tidak ditemukan untuk pengajuan ini.');
        }

        $petugas = $pengajuan->verifikator->name ?? '-';
        $tanggal = $pengajuan->tanggal_verifikasi
            ? \Carbon\Carbon::parse($pengajuan->tanggal_verifikasi)->format('d-m-Y H:i')
            : '-';
        $isiQR = "Verifikasi oleh: $petugas pada $tanggal";

        // Generate QR Code SVG base64
        $qrSvg = QrCode::format('svg')->size(200)->generate($isiQR);
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        $pdf = Pdf::loadView('dosen.invoice.kuitansi_pdf', [
            'pengajuan' => $pengajuan,
            // 'invoice' => $pengajuan->invoice,
            'qrBase64' => $qrBase64,
        ])->setPaper('A4');

        return $pdf->stream('kuitansi-'.$pengajuan->id.'.pdf');
    }
}
