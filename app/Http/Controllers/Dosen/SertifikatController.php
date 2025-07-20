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

        // Buat folder sementara
        $tempDir = storage_path('app/temp_sertifikat/' . $folderName);
        File::makeDirectory($tempDir, 0755, true, true);

        foreach ($pengajuan->mahasiswas as $mhs) {
            $pdf = Pdf::loadView('dosen.sertifikat.template', compact('pengajuan', 'mhs'))->setPaper([0, 0, 609.45, 935.43], 'landscape');
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
