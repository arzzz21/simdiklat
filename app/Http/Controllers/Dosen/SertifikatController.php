<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ZipArchive;
use File;
use Storage;
use App\Models\Pengajuan;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SertifikatController extends Controller
{
    public function downloadZip(Pengajuan $pengajuan)
    {
        if (now()->lt(\Carbon\Carbon::parse($pengajuan->tanggal_selesai))) {
            return back()->with('error', 'Sertifikat hanya bisa diunduh setelah tanggal selesai magang.');
        }

        $folderName = 'sertifikat_pengajuan_' .  $pengajuan->id;
        $zipFileName = 'sertifikat-' . Str::slug($pengajuan->jenisProgram->nama) . '-' . $pengajuan->id . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        //QR
        $isiQR = "Surat ini ditandatangani oleh: dr. Indarto, M.Si., M.M selaku Direktur Utama RS PKU Muhammadiyah Sukoharjo pada $pengajuan->tanggal_selesai";

        // Buat SVG base64 agar aman dipakai di PDF
        $qrSvg = QrCode::format('svg')->size(120)->generate($isiQR);
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        // Buat folder sementara
        $tempDir = storage_path('app/temp_sertifikat/' . $folderName);
        File::makeDirectory($tempDir, 0755, true, true);

        foreach ($pengajuan->mahasiswas as $mhs) {
            $pdf = Pdf::loadView('dosen.sertifikat.template', [
                'pengajuan' => $pengajuan,
                'mhs' => $mhs,
                'qrBase64' => $qrBase64,
            ])->setPaper([0, 0, 609.45, 935.43], 'landscape');
            $pdfPath = $tempDir . '/' . Str::slug($mhs->nama) . '.pdf';
            $pdf->save($pdfPath);
        }

        // Buat ZIP
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach (File::files($tempDir) as $file) {
                $zip->addFile($file->getRealPath(), $file->getFilename());
            }
            $zip->close();
        }

        // Hapus file sementara
        File::deleteDirectory($tempDir);

        // Download ZIP
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
