<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Pengajuan;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SuratController extends Controller
{
    public function cetakSurat(Pengajuan $pengajuan)
    {
        if (now()->lt(Carbon::parse($pengajuan->tanggal_selesai))) {
            abort(403, 'Surat belum dapat diterbitkan karena magang belum selesai.');
        }

        $isiQR = "Surat ini ditandatangani oleh: dr. Indarto, M.Si., M.M selaku Direktur Utama RS PKU Muhammadiyah Sukoharjo pada $pengajuan->tanggal_selesai";

        // Buat SVG base64 agar aman dipakai di PDF
        $qrSvg = QrCode::format('svg')->size(120)->generate($isiQR);
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        $pdf = PDF::loadView('dosen.surat.surat_keterangan', [
            'pengajuan' => $pengajuan,
            'qrBase64' => $qrBase64,
        ])->setPaper([0, 0, 609.45, 935.43], 'portrait'); // 215mm x 330mm dalam point

        return $pdf->stream('Surat-Keterangan-'.$pengajuan->id.'.pdf');
    }

    public function cetakSertifikat(Pengajuan $pengajuan)
    {
        if (now()->lt(Carbon::parse($pengajuan->tanggal_selesai))) {
            abort(403, 'Sertifikat belum dapat diterbitkan karena magang belum selesai.');
        }

        // $pdf = PDF::loadView('dosen.surat.sertifikat', compact('pengajuan'))->setPaper('A4', 'landscape');
        $isiQR = "Surat ini ditandatangani oleh: dr. Indarto, M.Si., M.M selaku Direktur Utama RS PKU Muhammadiyah Sukoharjo pada $pengajuan->tanggal_selesai";

        // Buat SVG base64 agar aman dipakai di PDF
        $qrSvg = QrCode::format('svg')->size(120)->generate($isiQR);
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        foreach ($pengajuan->mahasiswas as $mhs) {
            $pdf = Pdf::loadView('dosen.sertifikat.template', [
                'pengajuan' => $pengajuan,
                'mhs' => $mhs,
                'qrBase64' => $qrBase64,
            ])->setPaper([0, 0, 609.45, 935.43], 'landscape');
        }

        return $pdf->stream('Sertifikat-'.$pengajuan->id.'.pdf');
    }
}
