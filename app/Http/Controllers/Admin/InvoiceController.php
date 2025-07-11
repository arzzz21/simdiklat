<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pengajuan;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function create(Pengajuan $pengajuan)
    {
        $jenis = $pengajuan->jenisProgram;
        $biaya = $jenis->biaya;
        $tipeBiaya = $jenis->metode_biaya; // per_bulan, per_minggu, flat
        // Ambil jumlah mahasiswa
        $jumlahMahasiswa = $pengajuan->mahasiswas->count();

        // Parsing tanggal
        $tanggalMulai = Carbon::parse($pengajuan->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($pengajuan->tanggal_selesai);
        $jumlahHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        // Hitung bulan dan minggu
        $bulan = floor($jumlahHari / 30);
        $sisaHari = $jumlahHari % 30;
        $minggu = ceil($sisaHari / 7);

        // Jika 4 minggu, dianggap 1 bulan
        if ($minggu === 4) {
            $bulan += 1;
            $minggu = 0;
        }

        // Format tampilan lama magang
        $lamaMagang = '';
        $lamaParts = [];

        switch ($tipeBiaya) {
            case 'per_bulan':
                // Tambahkan 1 bulan jika ada sisa minggu/hari
                if ($minggu > 0 || $sisaHari > 0) {
                    $bulan += 1;
                    $minggu = 0;
                }

                $totalPerOrang = $bulan * $biaya;
                $total = $totalPerOrang * $jumlahMahasiswa;

                $lamaMagang = $bulan . ' bulan';
                break;

            case 'per_minggu':
                $jumlahMinggu = ceil($jumlahHari / 7);
                $totalPerOrang = $jumlahMinggu * $biaya;
                $total = $totalPerOrang * $jumlahMahasiswa;

                $lamaMagang = $jumlahMinggu . ' minggu';
                break;

            case 'flat':
            default:
                $totalPerOrang = $biaya;
                $total = $totalPerOrang * $jumlahMahasiswa;

                if ($bulan > 0) $lamaParts[] = "$bulan bulan";
                if ($minggu > 0) $lamaParts[] = "$minggu minggu";
                if ($sisaHari > 0) $lamaParts[] = "$sisaHari hari";
                if (empty($lamaParts)) $lamaParts[] = "0 hari";

                $lamaMagang = implode(' ', $lamaParts);
                break;
        }

        // Format tanggal
        $Mulai = $tanggalMulai->format('d-m-Y');
        $Selesai = $tanggalSelesai->format('d-m-Y');

        return view('admin.invoice.create', compact(
            'pengajuan',
            'jenis',
            'total',
            'Mulai',
            'Selesai',
            'lamaMagang',
            'jumlahMinggu',
            'jumlahHari',
            'jumlahMahasiswa',
            'totalPerOrang'
        ));
    }

    public function store(Request $request, Pengajuan $pengajuan)
    {
        $jenis = $pengajuan->jenisProgram;
        $biaya = $jenis->biaya;
        $tipeBiaya = $jenis->metode_biaya; // per_bulan, per_minggu, flat
        // Ambil jumlah mahasiswa
        $jumlahMahasiswa = $pengajuan->mahasiswas->count();

        // Parsing tanggal
        $tanggalMulai = Carbon::parse($pengajuan->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($pengajuan->tanggal_selesai);
        $jumlahHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        // Hitung bulan dan minggu
        $bulan = floor($jumlahHari / 30);
        $sisaHari = $jumlahHari % 30;
        $minggu = ceil($sisaHari / 7);

        // Jika 4 minggu, dianggap 1 bulan
        if ($minggu === 4) {
            $bulan += 1;
            $minggu = 0;
        }

        // Format tampilan lama magang
        $lamaMagang = '';
        $lamaParts = [];

        switch ($tipeBiaya) {
            case 'per_bulan':
                // Tambahkan 1 bulan jika ada sisa minggu/hari
                if ($minggu > 0 || $sisaHari > 0) {
                    $bulan += 1;
                    $minggu = 0;
                }

                $totalPerOrang = $bulan * $biaya;
                $total = $totalPerOrang * $jumlahMahasiswa;

                $lamaMagang = $bulan . ' bulan';
                break;

            case 'per_minggu':
                $jumlahMinggu = ceil($jumlahHari / 7);
                $totalPerOrang = $jumlahMinggu * $biaya;
                $total = $totalPerOrang * $jumlahMahasiswa;

                $lamaMagang = $jumlahMinggu . ' minggu';
                break;

            case 'flat':
            default:
                $totalPerOrang = $biaya;
                $total = $totalPerOrang * $jumlahMahasiswa;

                if ($bulan > 0) $lamaParts[] = "$bulan bulan";
                if ($minggu > 0) $lamaParts[] = "$minggu minggu";
                if ($sisaHari > 0) $lamaParts[] = "$sisaHari hari";
                if (empty($lamaParts)) $lamaParts[] = "0 hari";

                $lamaMagang = implode(' ', $lamaParts);
                break;
        }

        $invoice = Invoice::create([
            'pengajuan_id' => $pengajuan->id,
            'lama_magang' => $jumlahHari,
            'biaya_per_lama' => $biaya,
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
