<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Pengajuan;

class SuratController extends Controller
{
    public function cetakSurat(Pengajuan $pengajuan)
    {
        if (now()->lt(Carbon::parse($pengajuan->tanggal_selesai))) {
            abort(403, 'Surat belum dapat diterbitkan karena magang belum selesai.');
        }

        $pdf = PDF::loadView('dosen.surat.surat_keterangan', compact('pengajuan'))
            ->setPaper([0, 0, 609.45, 935.43], 'portrait') // 215mm x 330mm dalam point
            ->setOptions([
                'margin-top'    => 28.35,   // 1 cm = 28.35 point
                'margin-bottom' => 70.88,   // 2.5 cm = 70.88 point
                // kamu bisa tambah margin kiri/kanan jika perlu
            ]);

        return $pdf->stream('Surat-Keterangan-'.$pengajuan->id.'.pdf');
    }

    public function cetakSertifikat(Pengajuan $pengajuan)
    {
        if (now()->lt(Carbon::parse($pengajuan->tanggal_selesai))) {
            abort(403, 'Sertifikat belum dapat diterbitkan karena magang belum selesai.');
        }

        $pdf = PDF::loadView('dosen.surat.sertifikat', compact('pengajuan'))->setPaper('A4', 'landscape');

        return $pdf->stream('Sertifikat-'.$pengajuan->id.'.pdf');
    }
}
