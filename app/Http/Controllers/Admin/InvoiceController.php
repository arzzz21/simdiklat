<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function create(Pengajuan $pengajuan)
    {
        $jenis = $pengajuan->jenisProgram;
        $biaya = $jenis->biaya;
        $tipeBiaya = $jenis->metode_biaya; // isinya: 'per_bulan', 'per_minggu', atau 'flat'

        // Parsing tanggal
        $tanggalMulai = \Carbon\Carbon::parse($pengajuan->tanggal_mulai);
        $tanggalSelesai = \Carbon\Carbon::parse($pengajuan->tanggal_selesai);
        $jumlahHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        // Hitung bulan dan minggu
        $bulan = floor($jumlahHari / 30);
        $sisaHari = $jumlahHari % 30;
        $minggu = ceil($sisaHari / 7);

        // Jika 4 minggu, jadikan 1 bulan penuh
        if ($minggu == 4) {
            $bulan += 1;
            $minggu = 0;
        }

        // Hitung total berdasarkan tipe biaya
        switch ($tipeBiaya) {
            case 'per_bulan':
                $total = ceil(($bulan * $biaya) + ($minggu * ($biaya / 4)));
                break;

            case 'per_minggu':
                $jumlahMinggu = ceil($jumlahHari / 7);
                $total = $jumlahMinggu * $biaya;
                break;

            case 'flat':
            default:
                $total = $biaya;
                break;
        }

        // Format tanggal
        $Mulai = $tanggalMulai->format('d-m-Y');
        $Selesai = $tanggalSelesai->format('d-m-Y');

        // Format lama magang
        $lamaMagang = '';
        if ($bulan > 0) {
            $lamaMagang .= "$bulan bulan ";
        }else{
            $lamaMagang .= "0 bulan ";
        }
        if ($minggu > 0) {
            $lamaMagang .= "$minggu minggu";
        }else{
            $lamaMagang .= "0 minggu ";
        }
        $lamaMagang = trim($lamaMagang);

        return view('admin.invoice.create', compact(
            'pengajuan',
            'jenis',
            'total',
            'Mulai',
            'Selesai',
            'lamaMagang'
        ));
    }

    public function store(Request $request, Pengajuan $pengajuan)
    {
        $jenis = $pengajuan->jenisProgram;
        $biaya = $jenis->biaya;
        $tipeBiaya = $jenis->metode_biaya; // isinya: 'per_bulan', 'per_minggu', atau 'flat'

        $tanggalMulai = \Carbon\Carbon::parse($pengajuan->tanggal_mulai);
        $tanggalSelesai = \Carbon\Carbon::parse($pengajuan->tanggal_selesai);
        $selisihBulan = $tanggalMulai->diffInMonths($tanggalSelesai) + 1;

         // Parsing tanggal
        $tanggalMulai = \Carbon\Carbon::parse($pengajuan->tanggal_mulai);
        $tanggalSelesai = \Carbon\Carbon::parse($pengajuan->tanggal_selesai);
        $jumlahHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        $jumlahBulan = ceil($jumlahHari / 30);

        // Hitung bulan dan minggu
        $bulan = floor($jumlahHari / 30);
        $sisaHari = $jumlahHari % 30;
        $minggu = ceil($sisaHari / 7);

        // Jika 4 minggu, jadikan 1 bulan penuh
        if ($minggu == 4) {
            $bulan += 1;
            $minggu = 0;
        }

        // Hitung total berdasarkan tipe biaya
        switch ($tipeBiaya) {
            case 'per_bulan':
                $total = ceil(($bulan * $biaya) + ($minggu * ($biaya / 4)));
                break;

            case 'per_minggu':
                $jumlahMinggu = ceil($jumlahHari / 7);
                $total = $jumlahMinggu * $biaya;
                break;

            case 'flat':
            default:
                $total = $biaya;
                break;
        }

        $invoice = Invoice::create([
            'pengajuan_id' => $pengajuan->id,
            'jumlah_bulan' => $jumlahBulan,
            'biaya_per_bulan' => $biaya,
            'total' => $total,
            'status' => 'menunggu_pembayaran'
        ]);

        $pengajuan->update(['status' => 'invoice_diterbitkan']);

        return redirect()->route('admin.pengajuan.index')->with('success', 'Invoice berhasil diterbitkan.');
    }

    // // 1. Daftar invoice yg menunggu verifikasi
    // public function verifikasiIndex()
    // {
    //     $invoices = Invoice::where('status', 'menunggu_verifikasi')->with('pengajuan.jenisProgram')->get();
    //     return view('admin.invoice.verifikasi_index', compact('invoices'));
    // }

    // // 2. Tampilkan detail invoice
    // public function verifikasiShow(Invoice $invoice)
    // {
    //     $invoice->load('pengajuan.user', 'pengajuan.jenisProgram');
    //     return view('admin.invoice.verifikasi_show', compact('invoice'));
    // }

    // // 3. Simpan hasil verifikasi (lunas / ditolak)
    // public function verifikasiStore(Request $request, Invoice $invoice)
    // {
    //     $request->validate([
    //         'status' => 'required|in:lunas,ditolak',
    //     ]);

    //     $invoice->update(['status' => $request->status]);

    //     // Jika lunas, update juga status pengajuannya
    //     if ($request->status === 'lunas') {
    //         $invoice->pengajuan->update(['status' => 'selesai']);
    //     } elseif ($request->status === 'ditolak') {
    //         $invoice->pengajuan->update(['status' => 'diterima']); // atau kembali ke status sebelumnya
    //     }

    //     return redirect()->route('admin.invoice.verifikasi.index')
    //         ->with('success', 'Status pembayaran berhasil diperbarui.');
    // }

    public function verifikasiIndex(Request $request)
    {
        $query = Invoice::with('pengajuan.jenisProgram');

        // Filter status
        if ($request->filled('status')) {
            if ($request->status === 'belum') {
                $query->where('status', 'menunggu_verifikasi');
            } elseif ($request->status === 'sudah') {
                $query->whereIn('status', ['lunas', 'ditolak']);
            }
        }

        // Filter tanggal
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->tanggal_awal)->startOfDay(),
                Carbon::parse($request->tanggal_akhir)->endOfDay()
            ]);
        }

        $invoices = $query->orderBy('created_at', 'desc')->get();

        return view('admin.invoice.verifikasi_index', compact('invoices'));
    }

    public function verifikasiShow($id)
    {
        $invoice = Invoice::with('pengajuan.jenisProgram')->findOrFail($id);
        return view('admin.invoice.verifikasi_show', compact('invoice'));
    }

    public function verifikasiSimpan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:lunas,ditolak',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->status = $request->status;
        $invoice->save();

        return redirect()->route('admin.invoice.verifikasi.index')->with('success', 'Verifikasi berhasil disimpan.');
    }

}
