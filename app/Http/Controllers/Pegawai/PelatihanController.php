<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelatihan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PelatihanController extends Controller
{
    public function cetakSuratTugas(Pelatihan $pelatihan)
    {
        $pegawai = Auth::user()->pegawai;

        // Cek apakah pegawai terdaftar sebagai peserta
        if (!$pegawai || !$pelatihan->peserta->contains($pegawai->id)) {
            abort(403, 'Anda tidak memiliki akses ke surat tugas ini.');
        }

        $isiQR = "Surat ini ditandatangani oleh: dr. Indarto, M.Si., M.M selaku Direktur Utama RS PKU Muhammadiyah Sukoharjo pada $pelatihan->created_at";

        // Buat SVG base64 agar aman dipakai di PDF
        $qrSvg = QrCode::format('svg')->size(120)->generate($isiQR);
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        $pdf = PDF::loadView('pegawai.pelatihan.surat_tugas_pdf', [
            'pelatihan' => $pelatihan,
            'pegawai' => $pegawai,
            'qrBase64' => $qrBase64,
        ])->setPaper([0, 0, 609.45, 935.43], 'portrait'); // 215mm x 330mm dalam point

        return $pdf->stream('Surat-Tugas-'.$pelatihan->id.'.pdf');

        // return Pdf::loadView('pegawai.pelatihan.surat_tugas_pdf', compact('pelatihan', 'pegawai'))
        //     ->stream('surat-tugas-'.$pelatihan->id.'.pdf');
    }
}
