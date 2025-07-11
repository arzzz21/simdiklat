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

        $pdf = PDF::loadView('dosen.surat.surat_keterangan', compact('pengajuan'))->setPaper('A4');

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
